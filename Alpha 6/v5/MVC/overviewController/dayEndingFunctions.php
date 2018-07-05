<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class dayEndingFunctions
{

    public static function mapDayEnds($map){
        $deathCounter = 0;
        $deleted = false;

        //This happens before any players die (Sacrificing yourself for a god is the greatest honour right?
        avatarModel::resetShrineRewards($map->getMapID());
        dayEndingFunctions::calculateShrineBonuses($map);

        $avatarArray = avatarController::getAllMapAvatars($map->getMapID(),false);
        foreach ($avatarArray as $single) {
            $zone = new zoneController($single->getZoneID());
            $biomeClass = "biome".$zone->getBiomeType();
            $biome = new $biomeClass();
            $party = new partyController($single->getPartyID());
            $stats = buildingLevels::getTotalSurviveTemp($single,$zone,$biome,$party,false);
            $checkStatus = statuses::checkStatuses($single->getStatusArray());
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
            dayEndingFunctions::updateZoneInfo($map->getMapID());
            dayEndingFunctions::buildingChanges($map);
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
            $zone->addItem($item);
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
        $statusArray = statuses::changeStatuses($avatar->getStatusArray());
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
        $itemObjects = factoryClassArray::createAllItems();
        $itemArray = self::itemChanges($avatar->getInventory(),$itemObjects);
        $avatar->setInventory($itemArray);
        $biome = array("CAMPING",$zone->getBiomeType());
        $response = achievementController::checkAchievement($biome);
        if ($response !== false) {
            $avatar->addAchievement($response);
        }
        $avatar->updateAvatar();
    }

    public static function mapEndingActions($map){
        $map->deleteMap();
    }

    private static function calculateShrineBonuses($map){
        $shrineArray = zoneController::getMapShrines($map->getMapID());
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

    static function giveShrineBonus($shrine,$avatar){
        $bonus = $shrine->getShrineBonus();
        if(key_exists("ITEM",$bonus)){
            $avatar->addInventoryItem($bonus["ITEM"]);
        }
        $messageTitle = $shrine->getShrineAlertTitle();
        $messageText = $shrine->getShrineAlertMessage();
        $avatar->addCurrentFavour($shrine->getShrineID());
        profileAlertController::createNewAlert($avatar->getProfileID(),$messageText,$messageTitle,$avatar->getCurrentDay());
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
                    $zone->setBiomeType($biome->getDepletedTo());
                    $zone->resetFindingChances();
                }
            } else {
                $zone->setFindingChances($zone->getFindingChances() + 1);
            }
            $itemObjects = factoryClassArray::createAllItems();
            $itemArray = self::itemChanges($zone->getZoneItems(),$itemObjects);
            $zone->setZoneItems($itemArray);
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

    public static function itemChanges($itemArray,$itemObjects)
    {
        foreach ($itemArray as $key=>$item){
            if ($itemObjects[$item]->getDayEndChanges() === true){
                $effect = $itemObjects[$item]->dayEnding();
                if(array_key_exists("ITEM",$effect)){
                    $itemArray[$key] = $effect["ITEM"];
                }
            }
        }
        return $itemArray;
    }

    public static function buildingChanges($map)
    {
        $buildingList = factoryClassArray::createAllBuildings();
        foreach ($buildingList as $building){
            $response = $building->dayEndingActions($map);
            if ($response !== true){
                echo $response;
                exit();
            }
        }
    }


}