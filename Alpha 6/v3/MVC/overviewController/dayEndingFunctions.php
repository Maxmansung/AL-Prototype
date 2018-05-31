<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class dayEndingFunctions
{

    public static function mapDayEnds($map){
        $deathCounter = 0;
        $deleted = false;

        //This happens before any players die (Sacrificing yourself for a god is the greatest honour right?
        dayEndingFunctions::calculateShrineBonuses($map);

        $avatarArray = avatarController::getAllMapAvatars($map->getMapID(),false);
        foreach ($avatarArray as $single) {
            $zone = new zoneController($single->getZoneID());
            $biomeClass = "biome".$zone->getBiomeType();
            $biome = new $biomeClass();
            $party = new partyController($single->getPartyID());
            $stats = buildingLevels::getTotalSurviveTemp($single,$zone,$biome,$party,false);
            $checkStatus = statusesController::checkStatuses($single->getStatusArray());
            if ($single->getReady() === "dead") {
                $deathCounter++;
            } elseif ($checkStatus === "dead") {
                $statsAdjusted = buildingLevels::getTotalSurviveTemp($single,$zone,$biome,$party,true);
                $nightAdjusted = buildingLevels::totalNightTemp($map,$biome,true);
                dayEndingFunctions::playerDeath($single,2,$statsAdjusted,$nightAdjusted,$party,$map,$zone);
                $deathCounter++;
            }elseif ($stats < $map->getBaseNightTemperature()) {
                if ($checkStatus === "risk") {
                    $statsAdjusted = buildingLevels::getTotalSurviveTemp($single,$zone,$biome,$party,true);
                    $nightAdjusted = buildingLevels::totalNightTemp($map,$biome,true);
                    dayEndingFunctions::playerDeath($single,1,$statsAdjusted,$nightAdjusted,$party,$map,$zone);
                    $deathCounter++;
                } else {
                    chatlogPersonalController::getFrozen($single,$map->getCurrentDay());
                    dayEndingFunctions::playerSurvives($single,"cold",$stats,$map,$zone);
                }
            } else {
                dayEndingFunctions::playerSurvives($single,"normal",$stats,$map,$zone);
            }
        }
        if ($deathCounter !== $map->getMaxPlayerCount()) {
            $newTemp = buildingLevels::increaseNightTemperature($map->getCurrentDay());
            $map->setBaseNightTemperature($newTemp);
            $map->increaseCurrentDay();
            $map->addTemperatureRecord($map->getCurrentDay(), $map->getBaseNightTemperature());
            $map->updateMap();
        } else {
            $map->updateMap();
            dayEndingFunctions::mapEndingActions($map);
            $deleted = true;
        }
        if ($deleted == false) {
            //THIS NEEDED TO BE CLEANED UP A LOT!
            //dayEndingFunctions::buildingChanges($map->getMapID());

            dayEndingFunctions::updateZoneInfo($map->getMapID());
            dayEndingFunctions::changeMapItems($map->getMapID());
            $map->updateMap();
        }
    }

    public static function playerDeath($avatar,$deathType,$playerTemp,$nightTemp,$party,$map,$zone){
        deathScreenController::createNewDeathScreen($avatar,$deathType,$playerTemp,$nightTemp,$party->getPartyName(),$map);
        $avatar->toggleReady("dead");
        $party->removeMember($avatar->getAvatarID());
        if (count($party->getMembers()) < 1){
            $party->emptyParty();
        }
        $party->uploadParty();
        $profile = new profileController($avatar->getProfileID());
        $profile->setGameStatus("death");
        $profile->uploadProfile();
        foreach ($avatar->getInventory() as $item){
            $avatar->removeInventoryItem($item);
            $itemTemp = new itemController($item);
            $itemTemp->setItemLocation("ground");
            $itemTemp->setLocationID($avatar->getZoneID());
            $itemTemp->updateItem();
        }
        $zone->removeAvatar($avatar->getAvatarID());
        $zone->updateZone();
        $avatar->updateAvatar();
    }

    public static function playerSurvives($avatar,$modifier,$playerTemp,$map,$zone){
        $avatar->addAvatarTempRecord($map->getCurrentDay(),$playerTemp);
        if ($avatar->getReady() === 1) {
            $avatar->toggleReady("ready");
        }
        $avatar->setStamina($avatar->getMaxStamina());
        $statusArray = statusesController::changeStatuses($avatar->getStatusArray());
        $avatar->setStatusArray($statusArray);
        if ($map->getGameType() == "Tutorial"){
            if ($map->getCurrentDay() == 5){
                $avatar->addAchievement("A005");
            } elseif ($map->getCurrentDay() == 10){
                $avatar->addAchievement("A006");

            }
        }
        if ($modifier === "cold"){
            $avatar->changeStatusArray(3);
        }
        $biome = array("CAMPING",$zone->getBiomeType());
        $response = achievementController::checkAchievement($biome);
        if ($response !== false) {
            $avatar->addAchievement($response);
        }
        $avatar->updateAvatar();
    }

    public static function buildingChanges($mapID){
        //This function sets out the changes to all the firepits across the map
        $firepitArray = buildingController::getMapBuildings($mapID,"Firepit");
        foreach ($firepitArray as $firepit){
        }
        //This function creates a small animal in each zones with a trap
        $trapArray = buildingController::getMapBuildings($mapID,"Trap");
        foreach ($trapArray as $trap) {
            $zone = new zoneController($trap->getZoneID());
            $chances = rand(0,$zone->getCounter());
            if ($chances < 2) {
                $item = new itemController("");
                $item->createNewItemByID("I0007", $mapID,$trap->getZoneID(),"ground");
                $item->insertItem();
                chatlogZoneController::trapWorked($zone->getZoneID());
            }
        }
        //This function reduced the smoke signal building
        $smokeArray = buildingController::getMapBuildings($mapID,"Smoke");
        foreach ($smokeArray as $smoke){
            $building = new buildingController($smoke->getBuildingID());
            $currentFuel = $building->getFuelRemaining();
            $currentFuel = $currentFuel-1;
            $building->setFuelRemaining($currentFuel);
            if ($currentFuel <= 0){
                $zone = new zoneController($building->getZoneID());
                $zone->removeBuilding(buildingController::returnBuildingID("Smoke"));
                $building->deleteBuilding();
                $zone->updateZone();
                chatlogZoneController::smokeExpired($zone->getZoneID());
            } else {
                $building->postBuildingDatabase();
            }
        }
        $seedlingArray = buildingController::getMapBuildings($mapID,"Seedling");
        foreach ($seedlingArray as $seed) {
            $building = new buildingController($seed->getBuildingID());
            if($building->getStaminaRequired() === $building->getStaminaSpent()){
                $zone = new zoneController($building->getZoneID());
                $change = false;
                if ($zone->getBiomeType() <3 && $zone->getBiomeType() >0){
                    $change = 3;
                    chatlogZoneController::seedlingToScrub($zone->getZoneID());
                } else if ($zone->getBiomeType() == 3){
                    $change = 4;
                    chatlogZoneController::seedlingToForest($zone->getZoneID());
                }
                if ($change !== false) {
                    $zone->removeBuilding(buildingController::returnBuildingID("Seedling"));
                    $zone->setBiomeType($change);
                    $zone->resetFindingChances();
                    $building->deleteBuilding();
                    $zone->updateZone();
                }
            }
        }
        $rockArray = buildingController::getMapBuildings($mapID,"HeatRock");
        foreach ($rockArray as $rock){
            $building = new buildingController($rock->getBuildingID());
            $firepitBuilding = buildingController::getConstructedBuildingID("Firepit",$building->getZoneID());
            if (array_key_exists("ERROR",$firepitBuilding)){
                $building->setFuelRemaining(0);
            } else {
                $building->modifyFuelRemaining(1);
            }
            $building->postBuildingDatabase();
        }
    }



    public static function changeMapItems($mapID){
        //This changes all torches into burnt sticks overnight
        itemController::changeAllItems("I0003","I0005",$mapID);
    }

    public static function mapEndingActions($map){
        $map->deleteMap();
    }

    private static function calculateShrineBonuses($map){
        $shrineArray = shrineController::findMapShrines($map->getMapID());
        foreach ($shrineArray as $shrine){
            $results = $shrine->shrineRanks($map,array());
            if ($shrine->getOverallType() === 1){
                $list = shrineSolo::getRewardedPlayers($results);
                foreach ($list as $player){
                    $tempAvatar = new avatarController($player);
                    $currentScore = $tempAvatar->getFavourSolo() + $map->getCurrentDay();
                    $tempAvatar->setFavourSolo($currentScore);
                    self::giveShrineBonus($shrine,$tempAvatar,$map->getCurrentDay());
                }
            } else if ($shrine->getOverallType() === 2){
                $list = shrineTeam::getRewardedPlayers($results);
                foreach ($list as $party){
                    $tempParty = new partyController($party);
                    foreach ($tempParty->getMembers() as $avatar){
                        $tempAvatar = new avatarController($avatar);
                        $currentScore = $tempAvatar->getFavourTeam() + $map->getCurrentDay();
                        $tempAvatar->setFavourTeam($currentScore);
                        self::giveShrineBonus($shrine,$tempAvatar,$map->getCurrentDay());
                    }
                }
            } else if ($shrine->getOverallType() === 3){
                $check = shrineMap::getRewardedPlayers($results);
                if ($check === true){
                    $list = avatarController::getAllMapAvatars($map->getMapID(),false);
                    foreach ($list as $tempAvatar){
                        $currentScore = $tempAvatar->getFavourMap() + $map->getCurrentDay();
                        $tempAvatar->setFavourMap($currentScore);
                        self::giveShrineBonus($shrine,$tempAvatar,$map->getCurrentDay());
                    }
                }
            }
        }
    }

    static function giveShrineBonus($shrine,$avatar,$day){
        $bonus = $shrine->getShrineBonus();
        $messageText = "";
        $messageTitle = "";
        if(key_exists("ITEM",$bonus)){
            $item = new itemController("");
            $item->createNewItemByID($bonus["ITEM"],$avatar->getMapID(),$avatar->getAvatarID(),"backpack");
            $item->insertItem();
            $backpack = itemModel::getItemIDsFromLocation($avatar->getMapID(),"backpack",$avatar->getAvatarID());
            $avatar->setInventory($backpack);
            $messageText = $shrine->getShrineAlertMessage();
            $messageTitle = "Cold God's Champion";
        } else if(key_exists("STAMINA",$bonus)){
            $avatar->useStamina((intval($bonus['STAMINA'])*-1));
            $messageText = $shrine->getShrineAlertMessage();
            $messageTitle = "War God's Champion";

        } else if (key_exists("ZONES",$bonus)){

            $messageText = $shrine->getShrineAlertMessage();
            $messageTitle = "Life God's Champion";
        }
        $data = $day;
        profileAlertController::createNewAlert($avatar->getProfileID(),$messageText,$messageTitle,$data);
        $avatar->updateAvatar();
    }

    public static function updateZoneInfo($mapID){
        $zoneArray = zoneController::getAllZones($mapID,true);
        foreach ($zoneArray as $zone) {
            $zone->setCounter(0);
            if ($zone->getFindingChances() < 1) {
                $biomeClass = "biome".$zone->getBiomeType();
                $biome = new $biomeClass();
                if ($biome->getFinalType() !== 1) {
                    $zone->setBiomeType($zone->getBiomeType() - 1);
                    $zone->resetFindingChances();
                }
            } else {
                $zone->setFindingChances($zone->getFindingChances() + 1);
            }
            $zone->updateZone();
        }
    }



    public static function confirmDeath($profile){
        $deathScreen = new deathScreenController($profile->getProfileID());
        $details = new profileDetailsController($profile->getProfileID());
        if ($deathScreen->getGameType() !== 5) {
            if ($deathScreen->getDayDuration() == "full") {
                if ($deathScreen->getDeathAchievements() != "") {
                    $details->addAchievements($deathScreen->getDeathAchievements());
                }
                $details->increaseMainGames();
            } else {
                if ($deathScreen->getDeathAchievements() != "") {
                    $details->addAchievementsSolo($deathScreen->getDeathAchievements());
                }
                $details->increaseSpeedGames();
            }
            $checker = buildingLevels::checkFavourGained($deathScreen->getDayDuration(),$deathScreen->getGameType());
            if ($checker === true) {
                $details->addSoloLeaderboard($deathScreen->getFavourSolo());
                $details->addTeamLeaderboard($deathScreen->getFavourTeam());
                $details->addFullLeaderboard($deathScreen->getFavourMap());
            } else if ($checker === "life"){
                $details->addFullLeaderboard($deathScreen->getFavourMap());
            }
        }
        $profile->setGameStatus("ready");
        $profile->setAvatar(null);
        $deathScreen->deleteDeathScreen();
        $details->uploadProfile();
        $profile->uploadProfile();
        return array("ERROR"=>56);
    }


}