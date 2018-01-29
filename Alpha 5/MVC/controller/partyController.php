<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/controller/party.php");
require_once(PROJECT_ROOT."/MVC/model/partyModel.php");
class partyController extends party
{

    public function __construct($id)
    {
        if ($id != ""){
            $partyModel = partyModel::findParty($id);
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
        partyModel::insertParty($this,"Insert");
    }

    public function newParty($mapID,$idNum,$partyName){
        $this->partyID = $mapID.$idNum;
        $this->mapID = $mapID;
        $this->members = [];
        $this->partyName = $partyName;
        $this->pendingRequests = [];
        $this->pendingBans = [];
        $this->playersKnown = [];
        $this->tempBonus = 0;
    }

    public static function getPartyIDFromNumber($number){
        $count = 3 - (strlen((string)$number));
        $finalPartyID = "P";
        for ($i = 0; $i < $count; $i++) {
            $finalPartyID .= "0";
        }
        $finalPartyID .= $number;
        return $finalPartyID;
    }

    public static function getEmptyParty($mapID){
        $partyModel = partyModel::findEmptyParty($mapID);
        return new partyController($partyModel->getPartyID());
    }

    public static function removeAllInvites($playerID){
        $partyModelList = partyModel::removeInvites($playerID);
        foreach ($partyModelList as $party){
            $partyController = new partyController($party->getPartyID());
            $partyController->removePendingRequests($playerID);
            $partyController->uploadParty();
            chatlogGroupController::cancelGroupRequest($playerID,$partyController->getPartyID());
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
}