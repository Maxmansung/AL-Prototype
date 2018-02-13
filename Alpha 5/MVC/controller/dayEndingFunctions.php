<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class dayEndingFunctions
{

    public static function mapDayEnds($mapID){
        $map = new mapController($mapID);
        $deathCounter = 0;
        $deleted = false;
        $avatarArray = avatarController::getAllMapAvatars($map->getMapID());
        foreach ($avatarArray as $single) {
            $stats = buildingLevels::getTotalSurviveTemp($single->getAvatarID());
            $checkStatus = statusesController::checkStatuses($single->getStatusArray());
            if ($single->getReady() === "dead") {
                $deathCounter++;
            } elseif ($checkStatus === "dead") {
                dayEndingFunctions::playerDeath($single->getAvatarID(),2);
                $deathCounter++;
            }elseif ($stats < $map->getBaseNightTemperature()) {
                if ($checkStatus === "risk") {
                    dayEndingFunctions::playerDeath($single->getAvatarID(),1);
                    $deathCounter++;
                } else {
                    chatlogPersonalController::getFrozen($single->getAvatarID());
                    dayEndingFunctions::playerSurvives($single->getAvatarID(),"cold");
                }
            } else {
                dayEndingFunctions::playerSurvives($single->getAvatarID(),"normal");
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
            dayEndingFunctions::mapEndingActions($map->getMapID());
            $deleted = true;
        }
        if ($deleted == false) {
            dayEndingFunctions::buildingChanges($map->getMapID());
            dayEndingFunctions::updateZoneInfo($map->getMapID());
            dayEndingFunctions::changeMapItems($map->getMapID());
            dayEndingFunctions::calculateShrineBonuses($map->getMapID());
            shrineController::resetShrines($map->getMapID());
            $map->updateMap();
        }
    }

    public static function testPlayerSurvival($single,$nightTemp){
        $stats = buildingLevels::getTotalSurviveTemp($single->getAvatarID());
        $checkStatus = statusesController::checkStatuses($single->getStatusArray());
        if ($single->getReady() === "dead") {
            return 3;
        } elseif ($checkStatus === "dead") {
            return 2;
        }elseif ($stats < $nightTemp) {
            if ($checkStatus === "risk") {
                return 1;
            } else {
                return 0;
            }
        } else {
            return true;
        }
    }

    public static function playerDeath($avatarID,$deathType){
        $avatar = new avatarController($avatarID);
        $temp = buildingLevels::getTotalSurviveTemp($avatarID);
        deathScreenController::createNewDeathScreen($avatarID,$temp,$deathType);
        $avatar->toggleReady("dead");
        $party = new partyController($avatar->getPartyID());
        $party->removeMember($avatarID);
        $party->uploadParty();
        $profile = new profileController($avatar->getProfileID());
        $profile->setGameStatus("death");
        $profile->uploadProfile();
        $zone = new zoneController($avatar->getZoneID());
        foreach ($avatar->getInventory() as $item){
            $avatar->removeInventoryItem($item);
            $itemTemp = new itemController($item);
            $itemTemp->setItemLocation("ground");
            $itemTemp->setLocationID($avatar->getZoneID());
            $itemTemp->updateItem();
        }
        $zone->removeAvatar($avatarID);
        $zone->updateZone();
        $avatar->updateAvatar();
    }

    public static function playerSurvives($avatarID,$modifier){
        $newAvatar = new avatarController($avatarID);
        $map = new mapController($newAvatar->getMapID());
        $temp = buildingLevels::getTotalSurviveTemp($avatarID);
        $newAvatar->addAvatarTempRecord($map->getCurrentDay(),$temp);
        if ($newAvatar->getReady() == true) {
            $newAvatar->toggleReady("ready");
        }
        $newAvatar->setStamina($newAvatar->getMaxStamina());
        $statusArray = statusesController::changeStatuses($newAvatar->getStatusArray());
        $newAvatar->setStatusArray($statusArray);
        if ($map->getGameType() == "Tutorial"){
            if ($map->getCurrentDay() == 5){
                $newAvatar->addAchievement("A005");
            } elseif ($map->getCurrentDay() == 10){
                $newAvatar->addAchievement("A006");

            }
        }
        if ($modifier === "cold"){
            $newAvatar->changeStatusArray(3);
        }
        $zone = new zoneController($newAvatar->getZoneID());
        $biome = array("CAMPING",$zone->getBiomeType());
        $response = achievementController::checkAchievement($biome);
        if ($response !== false) {
            $newAvatar->addAchievement($response);
        }
        $newAvatar->updateAvatar();
    }

    public static function buildingChanges($mapID){
        //This function sets out the changes to all the firepits across the map
        $firepitArray = buildingController::getMapBuildings($mapID,"Firepit");
        foreach ($firepitArray as $firepit){
            $currentFuel = $firepit->getFuelRemaining();
            if ($currentFuel> 4){
                $currentFuel = floor($currentFuel/1.5);
            } else {
                $currentFuel = $currentFuel-2;
            }
            $firepit->setFuelRemaining($currentFuel);
            $firepit->postBuildingDatabase();
            $value = buildingItemController::firepitCheck($firepit->getBuildingID());
            if (array_key_exists("ERROR",$value) !== true){
                //In this situation we want the error to occur therefore this function is currently left blank as it should always occur
            }
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
    }



    public static function changeMapItems($mapID){
        //This changes all torches into burnt sticks overnight
        itemController::changeAllItems("I0003","I0005",$mapID);
    }

    public static function mapEndingActions($mapID){
        $map = new mapController($mapID);
        $map->deleteMap();
    }


    public static function calculateShrineBonuses($mapID){
        $highest = shrineController::highestScoreShrine($mapID);
        $map = new mapController($mapID);
        if ($highest === "ERROR"){
            //This means that no shrine has any tribute to it
        } elseif (is_array($highest)){
            //This means that 2 or more shrines have the same amount of tribute as the highest
            $parties = partyController::findAllParties($mapID);
            foreach ($highest as $shrine){
                self::giveShrineBonuses($shrine,$parties,$map);
            }
        } else {
            //This means a single shrine had the highest score
            $parties = partyController::findAllParties($mapID);
            self::giveShrineBonuses($highest,$parties,$map);
        }

    }

    private static function giveShrineBonuses($shrineID,$allParties,$map){
        $shrine = new shrineController($shrineID);
        chatlogWorldController::shrineBonusGained($shrine->getZoneID());
        foreach ($allParties as $single){
            $single->setTempBonus(0);
            $single->uploadParty();
            if (count($single->getMembers()) <= $shrine->getMaxParty()){
                if (count($single->getMembers()) >= $shrine->getMinParty()){
                    foreach ($single->getMembers() as $member){
                        $avatar = new avatarController($member);
                        $avatar->addShineScore($shrine->getShrineType(),$map->getCurrentDay());
                        buildingLevels::performShrineBonus($shrine->getShrineBonusType(),$shrine->getShrineBonusReward(),$avatar,$shrine->getShrineID());
                        $avatar->updateAvatar();
                    }
                }
            }
        }

    }

    public static function updateZoneInfo($mapID){
        $zoneArray = zoneController::getAllZones($mapID);
        foreach ($zoneArray as $zoneObject) {
            if ($zoneObject->getFindingChances() < 1) {
                $biome = new biomeTypeController($zoneObject->getBiomeType());
                if ($biome->getFinalType() !== 1) {
                    $zone = new zoneController($zoneObject->getZoneID());
                    $zone->setBiomeType($zone->getBiomeType() - 1);
                    $zone->resetFindingChances();
                    $zone->setCounter(0);
                    $zone->updateZone();
                }
            } else {
                $zone = new zoneController($zoneObject->getZoneID());
                $zone->setFindingChances($zone->getFindingChances() + 1);
                $zone->updateZone();
            }
        }
    }


}