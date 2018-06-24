<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class newMapJoinController
{
    private $inventMain = 5;
    private $inventTutorial = 6;
    private $stamina = 20;
    private $staminaTest = 100;
    private $temp = 0;
    private $stemp = 0;
    private $tempm = 0;
    private $minPlayer = 1;
    private $maxPlayers = 40;
    private $minEdge = 3;
    private $maxEdge = 20;

    public static function createNewMap($name,$player,$edge,$length,$profile,$type){
        $profile->getProfileAccess();
        if($profile->getAccessNewMap()===0){
            return array("ERROR"=>28);
        } else {
            $nameClean = preg_replace('#[^A-Za-z0-9 -]#i', '',$name);
            if ($profile->getAccessEditMap()===0){
                if ($profile->getCreatedMap() != 0) {
                    $map = new mapController($profile->getCreatedMap());
                    if ($map->getMapID() != 0) {
                        return array("ERROR" => "You can only create 1 map at a time, please wait for the last map to end");
                    }
                }
                $typeClean = 2;
            } else {
                $typeClean = intval(preg_replace('#[^0-9]#i', '',$type));
                if ($typeClean != 2){
                    modTrackingController::createNewTrack(1,$profile->getProfileID(),$typeClean,$nameClean,"","");
                }
            }
            $mapJoin = new newMapJoinController();
            $edgeClean = intval(preg_replace('#[^0-9]#i', '',$edge));
            $playerClean = intval(preg_replace('#[^0-9]#i', '',$player));
            $lengthClean = preg_replace('#[^A-Za-z0-9 -]#i', '',$length);
            $checker = $mapJoin->createMapFunction($nameClean, $playerClean, $edgeClean, $lengthClean,$typeClean);
            if (array_key_exists("ERROR",$checker)) {
                return $checker;
            } else {
                $profile->setCreatedMap($checker->getMapID());
                $profile->uploadProfile();
                return array("ALERT"=>24,"DATA"=>$checker->getName());
            }
        }
    }


    //This is the process to create a map using the MapCreate object
    public function createMapFunction($name,$player,$edge,$length,$type)
    {
        $map = new mapController("");
        if ($name == "" || $type > 2) {
            $checkname = 1;
            while ($checkname == 1) {
                if ($type < 3) {
                    $name = nameGeneratorController::getNameAsText("map");
                    //This checks to ensure the name is not already in use
                    $checkname = $map->checkname($name);
                } else if ($type == 3){
                    $name = nameGeneratorController::getNameAsText("practice");
                    $checkname = 0;
                } else if ($type == 4){
                    $name = "Tutorial Map";
                    $checkname = 0;
                } else {
                    if ($name == "") {
                        $name = "Test Map";
                    }
                    $checkname = 0;
                }
            }
        }
        //This checks to ensure the name is not already in use
        if ($type < 3) {
            $checkname = $map->checkname($name);
        } else {
            $checkname = 0;
        }
        if ($checkname > 0) {
            return array("ERROR" => 131);
        } else {
            if ($player < $this->minPlayer || $player > $this->maxPlayers) {
                return array("ERROR" => 132);
            } else {
                if ($edge < $this->minEdge || $edge > $this->maxEdge) {
                    return array("ERROR" => 133);
                } else {
                    if ($length !== "check" && $length !== "full"){
                        return array ("ERROR"=>136);
                    } else {
                        $stamina = $this->stamina;
                        if ($type > 2){
                            $invent = $this->inventTutorial;
                            if ($type > 3){
                                $stamina = $this->staminaTest;
                            }
                        } else {
                            $invent = $this->inventMain;
                        }
                        $map->newmap($name, $player, $invent, $edge, $stamina, $length, $this->temp, $this->stemp, $this->tempm, $type);
                        //This creates the zones
                        $counter = 0;
                        $forestLoc = $map->createForestLocation($edge);
                        $lakeLoc = $map->createLakeLocation($edge);
                        $shrineLoc = $map->createShrineLocation($edge);
                        for ($y = 0; $y < $edge; $y++) {
                            for ($x = 0; $x < $edge; $x++) {
                                $zone = new zoneController("");
                                $zone->newZone($map->getMapID(), $counter, $x, $y, $forestLoc, $shrineLoc, $lakeLoc);
                                $counter += 1;
                            }
                        }
                        for ($z = 0; $z <= $player; $z++) {
                            $party = new partyController("");
                            $checker = true;
                            while ($checker == true) {
                                $name = nameGeneratorController::getNameAsText("party");
                                $checker = partyController::findMatchingParty($map->getMapID(), $name);
                            }
                            $party->newParty($map->getMapID(), $name, newMapJoinController::overallExplorationArray($edge));
                        }
                        return $map;
                    }
                }
            }
        }
    }

    //This function adds an avatar to the map
    public static function addAvatar($mapID,$profile)
    {
        $profile->getProfileAccess();
        $mapcheck = new mapController($mapID);
        if ($mapcheck->getMapID() == "") {
            return array("ERROR" => 38);
        } elseif ($mapcheck->getMaxPlayerCount() <= (count($mapcheck->getAvatars()))) {
            //Echo error ID - this shows the map has filled
            return array("ERROR" => 14);
        } elseif (array_search($profile->getProfileID(), $mapcheck->getAvatars())) {
            //Echo error ID - This shows the player is already in the map
            return array("ERROR" => 15);
        } elseif ($profile->getGameStatus() != "ready") {
            //Echo error ID - this shows the player is already in a game
            return array("ERROR" => 16);
        } elseif ($mapcheck->getCurrentDay() != 1) {
            //Echo error ID - this shows the map is not a new map
            return array("ERROR" => 17);
        } elseif ($mapcheck->getGameType() < 3) {
            if ($profile->getAccessAllGames()===0) {
                //Echo error ID - this shows the player is trying to join a game they do not have access to
                return array("ERROR" => 52);
            }
        }
        //Create the avatar object and upload it to the database
        $avatar = new avatarController("");
        $avatar->newavatar($mapcheck, $profile);
        buildingLevels::getStartingAchievements($mapcheck->getGameType(),$avatar);
        $avatar->setInventory(buildingLevels::playerStartingItems());
        $avatar->setResearched(buildingController::getStartingBuildings());
        $avatar->updateAvatar();
        $checkAvatar = new avatarController($avatar->getAvatarID());
        if ($checkAvatar->getAvatarID() == ""){
            return array("ERROR"=>$avatar->returnVars());
        } else {
            //Add the avatarID to the maps avatar array and upload it to the database
            $mapcheck->addAvatar($avatar->getAvatarID());
            self::addPlayerToVote($avatar->getMapID(), $avatar->getAvatarID());
            //Update the zone to include the avatar
            $zone = new zoneController($avatar->getZoneID());
            $zone->addAvatar($avatar->getAvatarID());
            $zone->updateZone();
            //Update the party to include the avatar
            $party = new partyController($avatar->getPartyID());
            $party->addMember($avatar->getAvatarID());
            $party->addPlayersKnown($avatar->getAvatarID());
            if ($zone->getFindingChances() > 0){
                $find = 1;
            } else  {
                $find = 0;
            }
            $party->addOverallZoneExploration($zone->getName(),$zone->getBiomeType(),$find);
            $party->uploadParty();
            //Update the players profile with the avatarID and set status to "in"
            $profile->setAvatar($avatar->getAvatarID());
            $profile->setGameStatus("in");
            $profile->uploadProfile();
            $mapcheck->updateMap();
            chatlogMovementController::playerJoinsMap($avatar,$mapcheck->getCurrentDay());
            if ($mapcheck->getMaxPlayerCount() == count($mapcheck->getAvatars())) {
                $check = self::duplicateMap($mapcheck);
                if (array_key_exists("ERROR",$check)){
                    return array ("ERROR"=>"For some reason a new map couldn't be created");
                }
            }
            return array("ALERT" => 7, "DATA"=>$mapcheck->getName());
        }
    }

    private static function overallExplorationArray($size)
    {
        $count = $size * $size;
        $exploration = [];
        for ($x = 0; $x < $count; $x++) {
            $exploration[$x] = array("x","x",0);
        }
        return $exploration;
    }


    private static function addPlayerToVote($mapID,$avatarID){
        $avatarList = avatarController::getAllMapAvatars($mapID,false);
        $newAvatar = new avatarController($avatarID);
        foreach ($avatarList as $avatar){
            if ($avatar->getAvatarID() === $avatarID){
                foreach ($avatarList as $otherAvatar){
                    $avatar->addPartyVotePlayer($otherAvatar->getAvatarID());
                }
            }
            $avatar->addPartyVotePlayer($newAvatar->getAvatarID());
            avatarModel::insertAvatar($avatar,"Update");
        }
    }

    public static function duplicateMap($mapController){
        $mapJoin = new newMapJoinController();
        if ($mapController->getGameType() == 1 || $mapController->getGameType() == 3) {
            return $mapJoin->createMapFunction("", $mapController->getMaxPlayerCount(), $mapController->getEdgeSize(), $mapController->getDayDuration(), $mapController->getGameType());
        }
        elseif ($mapController->getGameType() == 4) {
            return $mapJoin->createMapFunction($mapController->getName(), 1, $mapController->getEdgeSize(), "check",$mapController->getGameType());
        } else {
            return array("ALERT"=>"There is not a map being made","DATA"=>"");
        }
    }

    public static function deleteMap($profile,$mapID,$password){
        $profile->getProfileAccess();
        if ($profile->getAccessEditMap()===0){
            return array("ERROR"=>28);
        } else {
            if ($password != data::$adminVar['deletePassword']){
                return array('ERROR'=>"Wrong Password");
            } else {
                $mapIDClean = intval(preg_replace('#[^0-9]#i', '', $mapID));
                $map = new mapController($mapIDClean);
                $map->deleteMap();
                modTrackingController::createNewTrack(5,$profile->getProfileID(),$map->getMapID(),$map->getGameType(),"","");
                return array("ALERT"=>21,"DATA"=>$map->getName());
            }
        }
    }
}