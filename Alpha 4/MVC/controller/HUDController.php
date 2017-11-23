<?php

///////// THIS CONTROLLER IS USED TO CALCULATE THE HUD STATISTICS FOR THE PLAYER

include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/zoneController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/biomeTypeController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/buildingItemController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/profileController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/deathScreenController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/newMapJoinController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/nameGeneratorController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/shrineController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogWorldController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/data/buildingLevels.php");

class HUDController
{
    //These are the cheat functions for the game
    private static $infiniteStamina = true;


    //These are the HUD object stats
    protected $playerStamina;
    protected $playerMaxStamina;
    protected $currentDay;
    protected $dayEnding;
    protected $nightTemp;
    protected $calcSurvTemp;
    protected $maxInventorySlots;
    protected $zoneID;
    protected $readyStatus;
    protected $avatarID;
    protected $clock;
    protected $mapName;
    protected $tempBaseSurvival;
    protected $tempItemsBonus;
    protected $tempZoneMod;
    protected $tempBuildings;
    protected $tempFirepit;
    protected $tempBlessings;

    function returnVars(){
        return get_object_vars($this);
    }

    function getPlayerStamina(){
        return $this->playerStamina;
    }

    function getPlayerMaxStamina(){
        return $this->playerMaxStamina;
    }

    function getCurrentDay(){
        return $this->currentDay;
    }

    function getDayEnding(){
        return $this->dayEnding;
    }

    function getNightTemp(){
        return $this->nightTemp;
    }

    function getCalcSurvTemp()
    {
        return $this->calcSurvTemp;
    }

    function getMaxInventorySlots(){
        return $this->maxInventorySlots;
    }

    function getZoneID(){
        return $this->zoneID;
    }

    function getReadyStatus(){
        return $this->readyStatus;
    }

    function getAvatarID(){
        return $this->avatarID;
    }

    function getClock(){
        return $this->clock;
    }

    function getMapName(){
        return $this->mapName;
    }

    function getBaseSurvivalTemp(){
        return $this->tempBaseSurvival;
    }

    function getItemBonusTemp(){
        return $this->tempItemsBonus;
    }

    function getZoneModTemp(){
        return $this->tempZoneMod;
    }

    function getBuildingsTemp(){
        return $this->tempBuildings;
    }

    function getFirepitTemp(){
        return $this->tempFirepit;
    }

    function getBlessingsTemp(){
        return $this->tempBlessings;
    }

    private function __construct($avatarModel,$mapModel,$survivalTemp)
    {
        $this->playerStamina = $avatarModel->getStamina();
        $this->playerMaxStamina = $avatarModel->getMaxStamina();
        $this->currentDay = $mapModel->getCurrentDay();
        $this->dayEnding = $mapModel->getDayEndTime()-time();
        $this->clock = date("H:i",time());
        $this->nightTemp = $mapModel->getBaseNightTemperature();
        $this->calcSurvTemp = $survivalTemp;
        $this->maxInventorySlots = $avatarModel->getMaxInventorySlots();
        $this->zoneID = $avatarModel->getZoneID();
        $this->readyStatus = $avatarModel->getReady();
        $this->avatarID = $avatarModel->getAvatarID();
        $this->mapName = $mapModel->getName();
        $this->tempBaseSurvival = buildingLevels::sleepingBagLevelBonus($avatarModel->getTempModLevel());
        $this->tempItemsBonus = avatarController::getItemBonuses($avatarModel->getMapID(),$avatarModel->getAvatarID());
        $this->tempBuildings = buildingLevels::buildingsTempIncrease($avatarModel->getAvatarID());
        $this->tempFirepit = buildingController::getFirepitBonus($avatarModel->getZoneID());
        $party = new partyController($avatarModel->getPartyID());
        $this->tempBlessings = $party->getTempBonus()+$avatarModel->getAvatarSurvivableTemp();
        $zone = new zoneController($avatarModel->getZoneID());
        $biome = new biomeTypeController($zone->getBiomeType());
        $this->tempZoneMod = $biome->getTemperatureMod();
    }

    public static function getHUDStats($avatarID){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $totalSurvival = buildingLevels::getTotalSurviveTemp($avatarID);
        return new HUDController($avatar,$map,$totalSurvival);
    }


    public static function changeReady($avatarID){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $avatar->toggleReady("ready");
        $avatar->updateAvatar();
        $response = array("ALERT"=>5,"DATA"=>$avatar->getReady());
        $avatarArray = avatarController::getAllMapAvatars($avatar->getMapID());
        $ready = 0;
        $count = count($avatarArray);
        foreach ($avatarArray as $single){
            if ($single->getReady() == true || $single->getReady() == "dead") {
                $ready++;
            }
        }
        if (count($map->getAvatars())==$map->getMaxPlayerCount()) {
            if ($ready === $count){
                $response = self::dayEnding($avatarID,"ready");
            }
        }
        return $response;
    }

    public static function adminDayEnding($profileID){
        $profile = new profileController($profileID);
        if ($profile->getAccountType() === "admin" || $profile->getAccountType() === "mod"){
            $response = self::dayEnding($profile->getAvatar(),"admin");
        } else {
            $response = array("ERROR"=>27);
        }
        return $response;
    }

    public static function dayEnding($avatarID,$type){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $deathCounter = 0;
        $deleted = false;
        if (count($map->getAvatars())==$map->getMaxPlayerCount() || $type === "admin") {
            $avatarArray = avatarController::getAllMapAvatars($avatar->getMapID());
            foreach ($avatarArray as $single) {
                $stats = self::getHUDStats($single->getAvatarID());
                if ($stats->getCalcSurvTemp() < $stats->getNightTemp() && $stats->getReadyStatus() != "dead") {
                    self::playerDeath($single->getAvatarID());
                    $stats->readyStatus = "dead";
                    $deathCounter++;
                }
                elseif ($stats->getReadyStatus() != "dead") {
                    $newAvatar = new avatarController($single->getAvatarID());
                    $newAvatar->addAvatarTempRecord($map->getCurrentDay(),$stats->getCalcSurvTemp());
                    if ($newAvatar->getReady() == true) {
                        $newAvatar->toggleReady("ready");
                    }
                    $newAvatar->setStamina($newAvatar->getMaxStamina());
                    if ($map->getGameType() == "Tutorial"){
                        if ($map->getCurrentDay() == 5){
                            $newAvatar->addAchievement("A005");
                        } elseif ($map->getCurrentDay() == 10){
                            $newAvatar->addAchievement("A006");

                        }
                    }
                    $newAvatar->updateAvatar();
                }
                else {
                   $deathCounter++;
                }
            }
            if ($deathCounter !== intval($map->getMaxPlayerCount())) {
                $newTemp = self::increaseNightTemperature($map->getBaseNightTemperature(), $map->getCurrentDay());
                $map->setBaseNightTemperature($newTemp);
                $map->increaseCurrentDay();
                self::buildingChanges($avatar->getMapID());
                $zoneArray = zoneController::getAllZones($map->getMapID());
                foreach ($zoneArray as $zoneObject) {
                    if ($zoneObject->getFindingChances() < 1) {
                        if ($zoneObject->getBiomeType() > 1) {
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
                self::changeMapItems($map->getMapID());
            } else {
                $map->deleteMap();
                $deleted = true;
            }
            $map->addTemperatureRecord($map->getCurrentDay(), $map->getBaseNightTemperature());
            $map->updateMap();
            self::calculateShrineBonuses($map->getMapID());
            shrineController::resetShrines($map->getMapID());
        }
        if ($deleted == false) {
            $dayEndTimer = mapController::createTimeStamp(floatval($map->getDayDuration()));
            $map->setDayEndTime($dayEndTimer);
            $map->updateMap();
            if (count($map->getAvatars()) == $map->getMaxPlayerCount() || $type === "admin") {
                return array("ERROR" => 29);
            } else {
                return array("ERROR" => 31);
            }
        } else {
            return array("ERROR"=>29);
        }
    }

    private static function increaseNightTemperature($currentTemp,$dayNumber){
        $newTemp = $currentTemp+(rand(1, 3)*$dayNumber);
        return $newTemp;
    }

    private static function buildingChanges($mapID){
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
            } else {
                $building->postBuildingDatabase();
            }
        }
    }

    public function tempCheckTimerEnd(){
        if ($this->dayEnding <= 0){
            return self::dayEnding($this->avatarID,"timer");
        } else {
            return array("ERROR"=>30);
        }
    }

    public static function testReady($avatarID){
        $avatar = new avatarController($avatarID);
        $avatarArray = avatarController::getAllMapAvatars($avatar->getMapID());
        $ready = 0;
        $count = count($avatarArray);
        foreach ($avatarArray as $single){
            if ($single->getReady() == true || $single->getReady() == "dead") {
                $ready++;
            }
        }
        return $count." / ".$ready;
    }

    private static function changeMapItems($mapID){
        itemController::changeAllItems("I0003","I0005",$mapID);
    }

    private static function playerDeath($avatarID){
        $avatar = new avatarController($avatarID);
        $HUD = HUDController::getHUDStats($avatar->getAvatarID());
        deathScreenController::createNewDeathScreen($avatarID,$HUD->getCalcSurvTemp());
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

    public static function refreshStamina($avatarID){
        if (HUDController::$infiniteStamina === true) {
            $avatar = new avatarController($avatarID);
            $avatar->setStamina($avatar->getMaxStamina());
            $avatar->updateAvatar();
            return array("ERROR"=>57);
        } else {
            return array("ERROR"=>100);
        }

    }

    public static function playerDeathButton($avatarID){
        $avatar = new avatarController($avatarID);
        $profile = new profileController($avatar->getProfileID());
        if ($profile->getAccountType() == "admin") {
            self::playerDeath($avatarID);
            $avatarCheck = new deathScreenController($avatar->getProfileID());
            if ($avatarCheck->getProfileID() != "") {
                return array("ERROR" => 55);
            } else {
                return array("ERROR" => "For some reason your avatar just wont die");
            }
        } else {
            return array("ERROR"=>"You dont have the power to do that");
        }
    }

    private static function calculateShrineBonuses($mapID){
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

    public static function testShrineBonuses($mapID){
        self::calculateShrineBonuses($mapID);
    }
}