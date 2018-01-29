<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class newMapJoinController
{

    //This is the process to create a map using the MapCreate object
    public static function createNewMap($name,$player,$invent,$edge,$stamina,$length,$temp,$stemp,$tempm,$type)
    {
        $map = new mapController("");
        if ($name == ""){
            $checkname = 1;
            while ($checkname == 1) {
                $tempName = nameGeneratorController::getNameAsText("map");
                $map->newmap($tempName, $player, $invent, $edge, $stamina, $length, $temp, $stemp, $tempm, $type);
                //This checks to ensure the name is not already in use
                $checkname = $map->checkname($tempName);
            }
        } else {
            $map->newmap($name, $player, $invent, $edge, $stamina, $length, $temp, $stemp, $tempm, $type);
            //This checks to ensure the name is not already in use
            if ($type !== "Tutorial") {
                $checkname = $map->checkname($name);
                if ($checkname > 0) {
                    return array("ERROR" => 1);
                }
            }
        }
        //This posts the map to the database
        $map->postMap();
        //This creates the zones
        $counter = 0;
        $forestLoc = $map->createForestLocation($edge);
        $lakeLoc = $map->createLakeLocation($edge);
        if ($map->getGameType() === "Tutorial"){
            $shrineLoc = [];
        } else {
            $shrineLoc = $map->createShrineLocation($edge);
        }
        for ($y = 0; $y < $edge; $y++) {
            for ($x = 0; $x < $edge; $x++) {
                $zone = new zoneController("");
                $count = 4 - (strlen((string)$counter));
                $finalZoneID = "z";
                for ($i = 0; $i < $count; $i++) {
                    $finalZoneID .= "0";
                }
                $finalZoneID .= $counter;
                $zone->newZone($map->getMapID(), $finalZoneID, $x, $y,$forestLoc,$shrineLoc,$lakeLoc);
                $zone->postZone();
                if ($zone->getProtectedType() !== "none"){
                    $shrine = shrineController::createNewShrine($zone->getProtectedType(),$zone->getZoneID());
                    $shrine->insertShrine();
                }
                $counter += 1;
            }
        }
        for($z=0;$z<=$player;$z++){
            $finalPartyID = partyController::getPartyIDFromNumber($z);
            $party = new partyController("");
            $checker = true;
            while ($checker == true){
                $name = nameGeneratorController::getNameAsText("party");
                $checker = partyController::findMatchingParty($map->getMapID(),$name);
            }
            $party->newParty($map->getMapID(),$finalPartyID,$name);
            $party->setZoneExploration(newMapJoinController::overallExplorationArray($edge));
            $party->insertParty();
        }
        return array("ERROR" => 2);
    }

    //This function adds an avatar to the map
    public static function addAvatar($mapID,$profileID)
    {
        $profile = new profileController($profileID);
        $mapcheck = new mapController($mapID);
        if ($mapcheck->getMapID() == "") {
            return array("ERROR" => 38);
        } elseif ($mapcheck->getMaxPlayerCount() < (count($mapcheck->getAvatars()))) {
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
        } elseif ($mapcheck->getGameType() != "Tutorial") {
            if ($profile->getAccountType() != "admin" && $profile->getAccountType() != "mod" && $profile->getAccountType() != "active") {
                //Echo error ID - this shows the player is trying to join a game they do not have access to
                return array("ERROR" => 52);
            }
        }
        //Add the avatarID to the maps avatar array and upload it to the database
        $mapcheck->addAvatar($mapcheck->getMapID() . $profile->getProfileID());
        $playerCount = count($mapcheck->getAvatars());
        //Create the avatar object and upload it to the database
        $avatar = new avatarController("");
        $avatar->newavatar($mapcheck, $profile);
        buildingLevels::getStartingAchievements($mapcheck->getGameType(),$avatar);
        $partyID = partyController::getPartyIDFromNumber($playerCount);
        $avatar->setPartyID($mapID . $partyID);
        $startingItems = buildingLevels::playerStartingItems();
        $avatar->setResearched(buildingController::getStartingBuildings($mapcheck->getGameType()));
        foreach ($startingItems as $item) {
            $object = new itemController("");
            $object->createNewItemByID($item, $mapcheck->getMapID(),$avatar->getAvatarID(),"backpack");
            $object->insertItem();
            $avatar->addInventoryItem($object->getItemID());
        }
        $avatar->insertAvatar();
        $checkAvatar = new avatarController($mapcheck->getMapID().$profile->getProfileID());
        if ($checkAvatar->getAvatarID() == ""){
            return array("ERROR"=>$avatar->returnVars());
        } else {
            self::addPlayerToVote($avatar->getMapID(), $avatar->getAvatarID());
            //Update the zone to include the avatar
            $zone = new zoneController($avatar->getZoneID());
            $zone->addAvatar($avatar->getAvatarID());
            $zone->updateZone();
            //Update the party to include the avatar
            $party = new partyController($mapID . $partyID);
            $party->addMember($avatar->getAvatarID());
            $party->addPlayersKnown($avatar->getAvatarID());
            $party->uploadParty();
            //Update the players profile with the avatarID and set status to "in"
            $profile->setAvatar($avatar->getAvatarID());
            $profile->setGameStatus("in");
            $profile->uploadProfile();
            $mapcheck->updateMap();
            chatlogMovementController::playerJoinsMap($avatar->getAvatarID());
            if ($mapcheck->getMaxPlayerCount() == count($mapcheck->getAvatars())) {
                self::duplicateMap($mapcheck);
            }
            return array("ALERT" => 7,"DATA"=>$mapcheck->getName());
        }
    }

    private static function explorationArray($size)
    {
        $count = $size * $size;
        $exploration = [];
        for ($x = 0; $x < $count; $x++) {
            array_push($exploration, 0);
        }
        return $exploration;
    }

    private static function overallExplorationArray($size)
    {
        $count = $size * $size;
        $exploration = [];
        for ($x = 0; $x < $count; $x++) {
            $exploration[$x] = array("x","x");
        }
        return $exploration;
    }


    private static function addPlayerToVote($mapID,$avatarID){
        $avatarList = avatarController::getAllMapAvatars($mapID);
        foreach ($avatarList as $avatar){
            if ($avatar->getAvatarID() === $avatarID){
                foreach ($avatarList as $otherAvatar){
                    $avatar->addPartyVotePlayer($otherAvatar->getAvatarID());
                }
            }
            $avatar->addPartyVotePlayer($avatarID);
            avatarModel::insertAvatar($avatar,"Update");
        }
    }

    public static function deleteGame($mapID,$access){
        if ($access === "admin"){
            $map = new mapController($mapID);
            if ($map->getMapID() == ""){
                return array("ERROR" => 38);
            } else {
                if ($map->getMapID() == "map00001"){
                    return array("ERROR" => 38);
                } else {
                    $response = $map->deleteMap();
                    if ($response !== "ERROR"){
                        return array("ALERT" => 8, "DATA"=>$response);
                    } else {
                        return array("ERROR"=>"Somehow the map wasn't deleted");
                    }
                }
            }
        } else {
            return array("ERROR" => 28);
        }
    }

    public static function duplicateMap($mapController){
        if ($mapController->getGameType() == "Main") {
            newMapJoinController::createNewMap(nameGeneratorController::getNameAsText("map"), $mapController->getMaxPlayerCount(), $mapController->getMaxPlayerInventorySlots(), $mapController->getEdgeSize(), $mapController->getMaxPlayerStamina(), $mapController->getDayDuration(), 1, $mapController->getBaseSurvivableTemperature(), $mapController->getBaseAvatarTemperatureModifier(),$mapController->getGameType());
        }
        elseif ($mapController->getGameType() == "Tutorial") {
            newMapJoinController::createNewMap($mapController->getName(), $mapController->getMaxPlayerCount(), $mapController->getMaxPlayerInventorySlots(), $mapController->getEdgeSize(), $mapController->getMaxPlayerStamina(), $mapController->getDayDuration(), 1, $mapController->getBaseSurvivableTemperature(), $mapController->getBaseAvatarTemperatureModifier(),$mapController->getGameType());
        }
    }
}