<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/baseController/avatar.php");
require_once(PROJECT_ROOT."/MVC/model/avatarModel.php");
class avatarController extends avatar
{

    public function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)){
                $avatarModel = $id;
            } else {
                $avatarModel = avatarModel::findAvatarID($id);
            }
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
            $this->forumPosts = $avatarModel->getForumPosts();
            $this->statusArray = $avatarModel->getStatusArray();
            $this->findingChanceMod = $avatarModel->getFindingChanceMod();
            $this->findingChanceFail = $avatarModel->getFindingChanceFail();
        }
    }

    public function newavatar($mapController, $profileController){
        $this->profileID = $profileController->getProfileName();
        $this->mapID = $mapController->getMapID();
        $this->stamina = $mapController->getMaxPlayerStamina();
        $this->maxStamina = $mapController->getMaxPlayerStamina();
        $this->zoneLocation($mapController->getEdgeSize(),count($mapController->getAvatars()),$mapController->getMaxPlayerCount(),$mapController->getMapID());
        $this->inventory = array();
        $this->maxInventorySlots = $mapController->getMaxPlayerInventorySlots();
        $this->partyID = $this->startParty($mapController->getMapID());
        $this->readiness = false;
        $this->avatarTempRecord = $mapController->getBaseAvatarTemperatureModifier();
        $this->avatarSurvivableTemp = self::getBaseAvatarTemperature($profileController);
        $this->achievements = array();
        $this->researchStats = array(1,0);
        $this->researched = [];
        $this->playStatistics = array();
        $this->tempModLevel = 1;
        $this->shrineScore = array();
        $this->statusArray = statusesController::createStatusArray();
        $newID = $this->insertAvatar();
        $this->avatarID = $newID;
        return $newID;
    }

    public function insertAvatar(){
        return avatarModel::insertAvatar($this,"Insert");
    }

    public function updateAvatar(){
        avatarModel::insertAvatar($this,"Update");
    }

    public function delete(){
        avatarModel::deleteAvatar($this->getAvatarID());
    }

    //This creates a zone location, currently designed to prevent any player from ending up in the same zone as another by dividing the map into player sections. This is not the ideal scenario
    private function zoneLocation($size, $playerCount, $mapPlayers,$mapID){
        //This divides the map by the number of players
        $partitionMap = ($size*$size)/$mapPlayers;
        //This makes a section of the map for the number of player in it
        //This selects a random zone between the players maximum zone number and the players minimum
        $zoneNumber = rand(($partitionMap*$playerCount),(($partitionMap*($playerCount+1))-1));
        $count = 4 - (strlen((string)$zoneNumber));
        $finalZoneID = "z";
        for ($i = 0; $i < $count; $i++) {
            $finalZoneID .= "0";
        }
        $finalZoneID .= $zoneNumber;
        $this->zoneID = zoneController::getZoneIDfromName($finalZoneID,$mapID);
    }

    private function startParty($mapID){
        $party = partyController::getEmptyParty($mapID);
        return $party->getPartyID();
    }

    public function useStamina($var){
        $this->stamina -= $var;
    }

    public static function getAllMapAvatars($mapID,$vars){
        $list = avatarModel::getAllMapAvatars($mapID);
        $finalArray = [];
        foreach ($list as $avatar){
            $avatarController = new avatarController($avatar);
            if ($vars === true){
                $finalArray[$avatarController->getAvatarID()] = $avatarController->returnVars();
            } else {
                $finalArray[$avatarController->getAvatarID()] = $avatarController;
            }
        }
        return $finalArray;
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

    public static function addNewPostsMap($mapID,$postID){
        $array = avatarModel::getAllMapAvatars($mapID);
        foreach ($array as $avatar){
            $avatar->addForumPosts($postID);
            avatarModel::insertAvatar($avatar,"Update");
        }
    }

    public function calculateFindingChanceMod(){
        $total = $this->getFindingChanceMod() - $this->getFindingChanceFail();
        if ($this->getSingleStatus(4) === 1){
            $total += 2;
        }
        if ($this->getSingleStatus(3) === 1){
            $total += 1;
        }
        return $total;
    }

}