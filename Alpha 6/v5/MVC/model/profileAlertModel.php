<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileAlertModel extends profileAlert
{
    private function __construct($profileModel)
    {
        $this->alertID = intval($profileModel['alertID']);
        $this->profileID = intval($profileModel['profileID']);
        $this->alertMessage = $profileModel['alertMessage'];
        $this->title = $profileModel['title'];
        $this->visible = intval($profileModel['visible']);
        $this->alerting = intval($profileModel['alerting']);
        $this->dataID = intval($profileModel['dataID']);
        $this->dataType = intval($profileModel['dataType']);
    }

    public static function getAlert($id) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM profileAlerts WHERE alertID= :id LIMIT 1');
        $req->execute(array('id' => $id));
        $alertModel = $req->fetch();
        return new profileAlertModel($alertModel);
    }

    public static function getProfileAlerts($profileID) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM profileAlerts WHERE profileID= :id AND visible= 1 LIMIT 10');
        $req->execute(array('id' => $profileID));
        $alertModel = $req->fetchAll();
        $finalArray = [];
        $counter = 0;
        foreach ($alertModel as $alert){
            $finalArray[$counter] = new profileAlertModel($alert);
            $counter++;
        }
        return $finalArray;
    }

    public static function alertRead($profileID,$id) {
        $db = db_conx::getInstance();
        $req = $db->prepare('UPDATE profileAlerts SET alerting= 0 WHERE alertID= :id AND profileID= :profileID LIMIT 1');
        $req->bindParam(':id', $id);
        $req->bindParam(':profileID', $profileID);
        $req->execute();
    }

    public static function alertGone($profileID,$id) {
        $db = db_conx::getInstance();
        $req = $db->prepare('UPDATE profileAlerts SET visible= 0 WHERE alertID= :id AND profileID= :profileID LIMIT 1');
        $req->bindParam(':id', $id);
        $req->bindParam(':profileID', $profileID);
        $req->execute();
    }

    public static function insertAlert($alertController, $type){
        $db = db_conx::getInstance();
        $alertID = intval($alertController->getAlertID());
        $profileID = intval($alertController->getProfileID());
        $alertMessage = $alertController->getAlertMessage();
        $title = $alertController->getTitle();
        $visible = intval($alertController->getVisible());
        $alerting = intval($alertController->getAlerting());
        $dataID = intval($alertController->getDataID());
        $dataType = intval($alertController->getDataType());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO profileAlerts (profileID, alertMessage, title, visible, alerting, dataID, dataType) VALUES (:profileID, :alertMessage, :title, :visible, :alerting, :dataID, :dataType)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE profileAlerts SET profileID= :profileID, alertMessage= :alertMessage, title= :title, visible= :visible, alerting= :alerting, dataID= :dataID, dataType= :dataType WHERE alertID= :alertID");
            $req->bindParam(':alertID', $alertID);
        }
        $req->bindParam(':profileID', $profileID);
        $req->bindParam(':alertMessage', $alertMessage);
        $req->bindParam(':title', $title);
        $req->bindParam(':visible', $visible);
        $req->bindParam(':alerting', $alerting);
        $req->bindParam(':dataID', $dataID);
        $req->bindParam(':dataType', $dataType);
        $req->execute();
    }

}