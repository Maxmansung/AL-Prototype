<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class modTrackingModel extends modTracking
{
    private function __construct($modModel)
    {
        $this->trackID = intval($modModel['trackID']);
        $this->actionType = intval($modModel['actionType']);
        $this->performedBy = intval($modModel['performedBy']);
        $this->timestampAction = intval($modModel['timestampAction']);
        $this->details1 = $modModel['details1'];
        $this->details2 = $modModel['details2'];
    }

    public static function getModTracking($id) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM modTracking WHERE trackID= :id LIMIT 1');
        $req->execute(array('id' => $id));
        $modModel = $req->fetch();
        return new modTrackingModel($modModel);
    }

    public static function insertModTrack($modController, $type){
        $db = db_conx::getInstance();
        $trackID = intval($modController->getTrackID());
        $actionType = intval($modController->getActionType());
        $performedBy = intval($modController->getPerformedBy());
        $timestampAction = intval($modController->getTimestampAction());
        $details1 = $modController->getDetails1();
        $details2 = $modController->getDetails2();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO modTracking (actionType, performedBy, timestampAction, details1, details2) VALUES (:actionType, :performedBy, :timestampAction, :details1, :details2)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE modTracking SET actionType= :actionType, performedBy= :performedBy, timestampAction= :timestampAction, details1= :details1, details2= :details2 WHERE trackID= :trackID");
            $req->bindParam(':trackID', $trackID);
        }
        $req->bindParam(':actionType', $actionType);
        $req->bindParam(':performedBy', $performedBy);
        $req->bindParam(':timestampAction', $timestampAction);
        $req->bindParam(':details1', $details1);
        $req->bindParam(':details2', $details2);
        $req->execute();
    }
}