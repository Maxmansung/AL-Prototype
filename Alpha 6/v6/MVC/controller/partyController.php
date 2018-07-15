<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/party.php");
require_once(PROJECT_ROOT."/MVC/model/partyModel.php");
class partyController extends party
{

    public function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)){
                $partyModel = $id;
            } else {
                $partyModel = partyModel::findParty($id);
            }
            $this->partyID = $partyModel->partyID;
            $this->mapID = $partyModel->mapID;
            $this->members = $partyModel->members;
            $this->partyName = $partyModel->partyName;
            $this->pendingRequests = $partyModel->pendingRequests;
            $this->pendingBans = $partyModel->pendingBans;
            $this->playersKnown = $partyModel->playersKnown;
            $this->overallZoneExploration = $partyModel->overallZoneExploration;
            $this->tempBonus = $partyModel->tempBonus;
        }
    }

    public function uploadParty(){
        partyModel::insertParty($this,"Update");
    }

    public function insertParty(){
        return partyModel::insertParty($this,"Insert");
    }

    public function newParty($mapID,$partyName,$exploration){
        $this->partyID = null;
        $this->mapID = $mapID;
        $this->members = [];
        $this->partyName = $partyName;
        $this->pendingRequests = [];
        $this->pendingBans = [];
        $this->playersKnown = [];
        $this->tempBonus = 0;
        $this->setZoneExploration($exploration);
        $newID = $this->insertParty();
        $this->partyID = $newID;
    }

    public static function getEmptyParty($mapID){
        $partyModel = partyModel::findEmptyParty($mapID);
        return new partyController($partyModel);
    }

    public static function removeAllInvites($playerID,$day){
        $partyModelList = partyModel::removeInvites($playerID);
        foreach ($partyModelList as $party){
            $partyController = new partyController($party);
            $partyController->removePendingRequests($playerID);
            $partyController->uploadParty();
            $avatar = new avatarController($playerID);
            chatlogGroupController::cancelGroupRequest($avatar,$partyController->getPartyID(),$day);
        }
    }

    public static function findMatchingParty($mapID, $partyName){
        return partyModel::findMatchingParty($mapID,$partyName);
    }

    public static function testRequests($mapID,$profileID){
        return partyModel::findPendingRequests($mapID,$profileID);
    }

    public static function findAllParties($mapID){
        $partyArray = partyModel::findAllMapParties($mapID);
        $finalArray = [];
        foreach ($partyArray as $party){
            $temp = new partyController($party);
            $finalArray[$party] = $temp;
        }
        return $finalArray;
    }


    //This function empties a party when the last player leaves it
    public function emptyParty()
    {
        $this->removeAllZoneExploration();
        $this->setMembers(array());
        $this->setPlayersKnown(array());
        $this->setPendingBans(array());
        $this->setPendingRequests(array());
        $partyName = str_replace($this->getMapID(), "", $this->getPartyID());
        $this->setPartyName($partyName);
        chatlogGroupController::deleteGroupLogs($this->getPartyID());
    }
}