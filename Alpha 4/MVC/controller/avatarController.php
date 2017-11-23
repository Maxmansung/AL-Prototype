<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatar.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/avatarModel.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/data/buildingLevels.php");
class avatarController extends avatar
{

    public function __construct($id)
    {
        if ($id != ""){
            $avatarModel = avatarModel::findAvatarID($id);
            $this->avatarID = $avatarModel->getAvatarID();
            $this->profileID = $avatarModel->getProfileID();
            $this->mapID = $avatarModel->getMapID();
            $this->stamina = $avatarModel->getStamina();
            $this->maxStamina = $avatarModel->getMaxStamina();
            $this->zoneID = $avatarModel->getZoneID();
            $this->inventory = $avatarModel->getInventory();
            $this->maxInventorySlots = $avatarModel->getMaxInventorySlots();
            $this->partyID = $avatarModel->getPartyID();
            $this->readiness = $avatarModel->getReady();
            $this->avatarTempRecord = $avatarModel->getavatarTempRecord();
            $this->avatarSurvivableTemp = $avatarModel->getAvatarSurvivableTemp();
            $this->achievements = $avatarModel->getAchievements();
            $this->partyVote = $avatarModel->getPartyVote();
            $this->researchStats = $avatarModel->getResearchStats();
            $this->researched = $avatarModel->getResearched();
            $this->playStatistics = $avatarModel->getPlayStatistics();
            $this->tempModLevel = $avatarModel->getTempModLevel();
            $this->shrineScore = $avatarModel->getShrineScore();
        }
    }

    public function newavatar($mapController, $profileController){
        $this->avatarID = $mapController->getMapID().$profileController->getProfileID();
        $this->profileID = $profileController->getProfileID();
        $this->mapID = $mapController->getMapID();
        $this->stamina = $mapController->getMaxPlayerStamina();
        $this->maxStamina = $mapController->getMaxPlayerStamina();
        $this->zoneID = $this->zoneLocation($mapController->getEdgeSize(),count($mapController->getAvatars()),$mapController->getMaxPlayerCount(),$mapController->getMapID());
        $this->inventory = array();
        $this->maxInventorySlots = $mapController->getMaxPlayerInventorySlots();
        $this->partyID = $this->startParty();
        $this->readiness = false;
        $this->avatarTempRecord = $mapController->getBaseAvatarTemperatureModifier();
        $this->avatarSurvivableTemp = self::getBaseAvatarTemperature($profileController);
        $this->achievements = array();
        $this->researchStats = array(1,0);
        $this->researched = buildingLevels::startingBuildings();
        $this->playStatistics = array();
        $this->tempModLevel = 1;
        $this->shrineScore = array();
    }

    public function insertAvatar(){
        avatarModel::insertAvatar($this,"Insert");
    }

    public function updateAvatar(){
        avatarModel::insertAvatar($this,"Update");
    }

    public function delete(){
        avatarModel::deleteAvatar($this->getAvatarID());
    }

    //This creates a zone location, currently designed to prevent any player from ending up in the same zone as another by dividing the map into player sections. This is not the ideal scenario
    private function zoneLocation($size, $playerCount, $mapPlayers,$name){
        //This divides the map by the number of players
        $partitionMap = ($size*$size)/$mapPlayers;
        //This makes a section of the map for the number of player it is
        $personalMap = $partitionMap*$playerCount;
        //This selects a random zone between the players maximum zone number and the players minimum
        $this->zoneNumber = rand(($personalMap-$partitionMap),($personalMap));
        $count = 4 - (strlen((string)$this->zoneNumber));
        $finalZoneID = "z";
        for ($i = 0; $i < $count; $i++) {
            $finalZoneID .= "0";
        }
        $finalZoneID .= $this->zoneNumber;
        return $name.$finalZoneID;
    }

    private function startParty(){
        return null;
    }

    public function useStamina($var){
        $this->stamina -= $var;
    }

    public static function getAllMapAvatars($mapID){
        return avatarModel::getAllMapAvatars($mapID);
    }

    public static function removePartyVotesForPlayer($partyID,$avatarID){
        $avatarArray = avatarModel::getAllPartyAvatars($partyID);
        foreach ($avatarArray as $avatar){
            $avatarController = new avatarController($avatar->getAvatarID());
            $avatarController->changePartyVote($avatarID,0);
            $avatarController->updateAvatar();
        }
    }

    private static function getBaseAvatarTemperature($profileController){
        return 0;
    }


    public static function getItemBonuses($mapID,$avatarID)
    {
        $response = itemController::getItemsAsObjects($mapID, "backpack", $avatarID);
        $bonus = 0;
        foreach ($response as $item) {
            $bonus += $item->getSurvivalBonus();
        }
        return $bonus;
    }

}