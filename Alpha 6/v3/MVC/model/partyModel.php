<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class partyModel extends party
{
    private function __construct($partyModel)
    {
        $this->partyID = $partyModel['partyID'];
        $this->mapID = intval($partyModel['mapID']);
        $this->members = json_decode($partyModel['members']);
        $this->partyName = $partyModel['partyName'];
        $this->pendingRequests = json_decode($partyModel['pendingRequests']);
        $this->pendingBans = json_decode($partyModel['pendingBans']);
        $this->playersKnown = json_decode($partyModel['playersKnown']);
        $this->overallZoneExploration = json_decode($partyModel['overallZoneExploration']);
        $this->tempBonus = intval($partyModel['tempBonus']);
    }

    public static function findParty($partyID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Party WHERE partyID= :partyID LIMIT 1');
        $req->execute(array(':partyID' => $partyID));
        $partyModel = $req->fetch();
        return new partyModel($partyModel);
    }


    public static function insertParty($controller, $type){
        $db = db_conx::getInstance();
        $partyID = $controller->getPartyID();
        $mapID = intval($controller->getMapID());
        $members = json_encode($controller->getMembers(),JSON_NUMERIC_CHECK);
        $partyName = $controller->getPartyName();
        $pendingRequests = json_encode($controller->getPendingRequests(),JSON_NUMERIC_CHECK);
        $pendingBans = json_encode($controller->getPendingBans(),JSON_NUMERIC_CHECK);
        $playersKnown = json_encode($controller->getPlayersKnown(),JSON_NUMERIC_CHECK);
        $overallZoneExploration = json_encode($controller->getZoneExploration(),JSON_NUMERIC_CHECK);
        $tempBonus = $controller->getTempBonus();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Party (mapID, members, partyName, pendingRequests, pendingBans, playersKnown, overallZoneExploration, tempBonus) VALUES (:mapID, :members, :partyName, :pendingRequests, :pendingBans, :playersKnown, :overallZoneExploration, :tempBonus)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE Party SET mapID= :mapID, members= :members, partyName= :partyName, pendingRequests= :pendingRequests, pendingBans= :pendingBans, playersKnown= :playersKnown, overallZoneExploration= :overallZoneExploration, tempBonus= :tempBonus WHERE partyID= :partyID");
            $req->bindParam(':partyID', $partyID);
        }
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':members', $members);
        $req->bindParam(':partyName', $partyName);
        $req->bindParam(':pendingRequests', $pendingRequests);
        $req->bindParam(':pendingBans', $pendingBans);
        $req->bindParam(':playersKnown', $playersKnown);
        $req->bindParam(':overallZoneExploration', $overallZoneExploration);
        $req->bindParam(':tempBonus', $tempBonus);
        $req->execute();
        if ($type == "Insert"){
            $test = $db->lastInsertId();
            return $test;
        }
    }

    public static function removeInvites($playerID){
        $avatarID = "%".$playerID."%";
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Party WHERE pendingRequests LIKE :avatarID');
        $req->bindParam(':avatarID', $avatarID);
        $req->execute();
        $partyList = $req->fetchAll();
        $partyArray = [];
        foreach ($partyList as $party) {
            $partyModel = new partyModel($party);
            array_push($partyArray,$partyModel);
        }
        return $partyArray;
    }

    public static function findEmptyParty($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Party WHERE mapID= :mapID AND members= :members LIMIT 1');
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':members', json_encode(array()));
        $req->execute();
        $partyModel = $req->fetch();
        return new partyModel($partyModel);
    }

    public static function findMatchingParty($mapID, $partyName){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Party WHERE mapID= :mapID AND partyName= :partyName');
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':partyName', $partyName);
        $req->execute();
        $partyModel = $req->fetchAll();
        if (count($partyModel) > 0){
            return true;
        } else {
            return false;
        }

    }

    public static function findPendingRequests($mapID, $profileID){
        $adjustedProfile = "%".$profileID."%";
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Party WHERE mapID= :mapID AND pendingRequests LIKE :playerID');
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':playerID', $adjustedProfile);
        $req->execute();
        $partyModel = $req->fetchAll();
        if (count($partyModel) > 0){
            return true;
        } else {
            return false;
        }

    }

    public static function findAllMapParties($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT partyID FROM Party WHERE mapID= :mapID');
        $req->bindParam(':mapID', $mapID);
        $req->execute();
        $partyModel = $req->fetchAll();
        $partyArray = [];
        foreach ($partyModel as $party){
            array_push($partyArray,$party["partyID"]);
        }
        return $partyArray;
    }

}