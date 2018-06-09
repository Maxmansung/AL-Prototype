<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileWarningModel extends profileWarning
{
    private function __construct($warningModel)
    {
        $this->warningID = intval($warningModel['warningID']);
        $this->profileID = intval($warningModel['profileID']);
        $this->warningType = intval($warningModel['warningType']);
        $this->reason = $warningModel['reason'];
        $this->points = intval($warningModel['points']);
        $this->active = intval($warningModel['active']);
        $this->givenTimestamp = intval($warningModel['givenTimestamp']);
        $this->profileGiven = intval($warningModel['profileGiven']);
    }

    public static function findWarning($warningID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM profileWarnings WHERE warningID= :warningID LIMIT 1');
        $req->execute(array(':warningID' => $warningID));
        $warningModel = $req->fetch();
        return new profileWarningModel($warningModel);
    }

    public static function insertWarning($warningController, $type){
        $db = db_conx::getInstance();
        $warningID = intval($warningController->getWarningID());
        $profileID = intval($warningController->getProfileID());
        $warningType = intval($warningController->getWarningType());
        $reason = $warningController->getReason();
        $points = intval($warningController->getPoints());
        $active = intval($warningController->getActive());
        $givenTimestamp = intval($warningController->getGivenTimestamp());
        $profileGiven = intval($warningController->getProfileGiven());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO profileWarnings (profileID, warningType, reason, points, active, givenTimestamp, profileGiven) VALUES (:profileID, :warningType, :reason, :points, :active, :givenTimestamp, :profileGiven)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE profileWarnings SET profileID= :profileID, warningType= :warningType, reason= :reason, points= :points, active= :active, givenTimestamp= :givenTimestamp, profileGiven= :profileGiven WHERE warningID= :warningID ");
            $req->bindParam(':warningID', $warningID);
        }
        $req->bindParam(':profileID', $profileID);
        $req->bindParam(':warningType', $warningType);
        $req->bindParam(':reason', $reason);
        $req->bindParam(':points', $points);
        $req->bindParam(':active', $active);
        $req->bindParam(':givenTimestamp', $givenTimestamp);
        $req->bindParam(':profileGiven', $profileGiven);
        $req->execute();
    }

    public static function getProfileWarnings($profileID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM profileWarnings WHERE profileID= :profileID');
        $req->execute(array(':profileID' => $profileID));
        $warningModel = $req->fetchAll();
        $finalArray = [];
        foreach ($warningModel as $warning){
            $temp = new profileWarningModel($warning);
            $finalArray[$temp->getWarningID()] = $temp;
        }
        return $finalArray;
    }
}