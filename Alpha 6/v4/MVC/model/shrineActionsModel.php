<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class shrineActionsModel extends shrineActions
{

    private function __construct($shrineModel)
    {
        $this->worshipID = intval($shrineModel['worshipID']);
        $this->avatar = intval($shrineModel['avatar']);
        $this->profileName = $shrineModel['profileName'];
        $this->partyID = intval($shrineModel['partyID']);
        $this->partyName = $shrineModel['partyName'];
        $this->mapID = intval($shrineModel['mapID']);
        $this->currentDay = intval($shrineModel['currentDay']);
        $this->shrineID = intval($shrineModel['shrineID']);
        $this->shrineType = intval($shrineModel['shrineType']);
        $this->worshipTime = intval($shrineModel['worshipTime']);
    }

    public static function getSingleAction($actionID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrineActions WHERE worshipID= :worshipID LIMIT 1');
        $req->bindParam(':worshipID', $actionID);
        $req->execute();
        $shrineAction = $req->fetch();
        return new shrineActionsModel($shrineAction);

    }

    public static function getShrineActions($shrineID,$currentDay){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrineActions WHERE shrineID= :shrineID AND currentDay= :currentDay');
        $req->bindParam(':shrineID', $shrineID);
        $req->bindParam(':currentDay', $currentDay);
        $req->execute();
        $shrineAction = $req->fetchAll();
        $finalArray = [];
        foreach ($shrineAction as $shrine) {
            $temp = new shrineActionsModel($shrine);
            $finalArray[$temp->getWorshipID()] = $temp;
        }
        return $finalArray;
    }

    public static function getMapActions($mapID,$currentDay){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrineActions WHERE mapID= :mapID AND currentDay= :currentDay');
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':currentDay', $currentDay);
        $req->execute();
        $shrineAction = $req->fetchAll();
        $finalArray = [];
        foreach ($shrineAction as $shrine) {
            $temp = new shrineActionsModel($shrine);
            $finalArray[$temp->getWorshipID()] = $temp;
        }
        return $finalArray;
    }

    public static function getPlayerActions($avatarID,$currentDay){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrineActions WHERE avatar= :avatarID AND currentDay= :currentDay');
        $req->bindParam(':avatarID', $avatarID);
        $req->bindParam(':currentDay', $currentDay);
        $req->execute();
        $shrineAction = $req->fetchAll();
        $finalArray = [];
        foreach ($shrineAction as $shrine) {
            $temp = new shrineActionsModel($shrine);
            $finalArray[$temp->getWorshipID()] = $temp;
        }
        return $finalArray;
    }

    public static function getPartyActions($partyID,$currentDay){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrineActions WHERE partyID= :partyID AND currentDay= :currentDay');
        $req->bindParam(':partyID', $partyID);
        $req->bindParam(':currentDay', $currentDay);
        $req->execute();
        $shrineAction = $req->fetchAll();
        $finalArray = [];
        foreach ($shrineAction as $shrine) {
            $temp = new shrineActionsModel($shrine);
            $finalArray[$temp->getWorshipID()] = $temp;
        }
        return $finalArray;
    }

    public static function insertAction($controller, $type){
        $db = db_conx::getInstance();
        $worshipID = $controller->getWorshipID();
        $avatar = $controller->getAvatar();
        $profileName = $controller->getProfileName();
        $partyID = $controller->getPartyID();
        $partyName = $controller->getPartyName();
        $mapID = $controller->getMapID();
        $currentDay = $controller->getCurrentDay();
        $shrineID = $controller->getShrineID();
        $shrineType = $controller->getShrineType();
        $worshipTime = $controller->getWorshipTime();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO shrineActions (avatar, profileName, partyID, partyName, mapID, currentDay, shrineID, shrineType, worshipTime) VALUES (:avatar, :profileName, :partyID, :partyName,:mapID, :currentDay, :shrineID, :shrineType, :worshipTime)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE shrineActions SET avatar= :avatar, profileName= :profileName, partyID= :partyID, partyName= :partyName, mapID= :mapID, currentDay= :currentDay, shrineID= :shrineID, shrineType= :shrineType, worshipTime= :worshipTime WHERE shrineID= :shrineID");
            $req->bindParam(':worshipID', $worshipID);
        }
        $req->bindParam(':avatar', $avatar);
        $req->bindParam(':profileName', $profileName);
        $req->bindParam(':partyID', $partyID);
        $req->bindParam(':partyName', $partyName);
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':currentDay', $currentDay);
        $req->bindParam(':shrineID', $shrineID);
        $req->bindParam(':shrineType', $shrineType);
        $req->bindParam(':worshipTime', $worshipTime);
        $req->execute();
    }

    public static function deleteAction($worshipID)
    {
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM shrineActions WHERE worshipID= :worshipID LIMIT 1');
        $req->execute(array('worshipID' => $worshipID));
    }

    public static function deleteShrineActions($avatarID,$shrineType,$currentDay){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM shrineActions WHERE avatar= :avatarID AND shrineType= :shrineType AND currentDay= :currentDay');
        $req->bindParam(':shrineType', $shrineType);
        $req->bindParam(':avatarID', $avatarID);
        $req->bindParam(':currentDay', $currentDay);
        $req->execute();
    }

    public static function deleteShrineActionsParty($partyID,$shrineType,$currentDay){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM shrineActions WHERE partyID= :partyID AND shrineType= :shrineType AND currentDay= :currentDay');
        $req->bindParam(':shrineType', $shrineType);
        $req->bindParam(':partyID', $partyID);
        $req->bindParam(':currentDay', $currentDay);
        $req->execute();
    }

}