<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/connection/db_conx.php");
class partyModel extends party
{
    private function __construct($partyModel)
    {
        $this->partyID = $partyModel['partyID'];
        $this->mapID = $partyModel['mapID'];
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
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Party (partyID, mapID, members, partyName, pendingRequests, pendingBans, playersKnown, overallZoneExploration, tempBonus) VALUES (:partyID, :mapID, :members, :partyName, :pendingRequests, :pendingBans, :playersKnown, :overallZoneExploration, :tempBonus)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE Party SET mapID= :mapID, members= :members, partyName= :partyName, pendingRequests= :pendingRequests, pendingBans= :pendingBans, playersKnown= :playersKnown, overallZoneExploration= :overallZoneExploration, tempBonus= :tempBonus WHERE partyID= :partyID");;
        }
        $req->bindParam(':partyID', $controller->getPartyID());
        $req->bindParam(':mapID', $controller->getMapID());
        $req->bindParam(':members', json_encode($controller->getMembers()));
        $req->bindParam(':partyName', $controller->getPartyName());
        $req->bindParam(':pendingRequests', json_encode($controller->getPendingRequests()));
        $req->bindParam(':pendingBans', json_encode($controller->getPendingBans()));
        $req->bindParam(':playersKnown', json_encode($controller->getPlayersKnown()));
        $req->bindParam(':overallZoneExploration', json_encode($controller->getZoneExploration()));
        $req->bindParam(':tempBonus', $controller->getTempBonus());
        $req->execute();
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