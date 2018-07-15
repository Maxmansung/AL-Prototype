<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/profileAlert.php");
require_once(PROJECT_ROOT."/MVC/model/profileAlertModel.php");
class profileAlertController extends profileAlert
{
    public function __construct($id)
    {
        if ($id != "") {
            if (is_object($id)) {
                $alertModel = $id;
            } else {
                $alertModel = profileAlertModel::getAlert($id);
            }
            $this->alertID = $alertModel->getAlertID();
            $this->profileID = $alertModel->getProfileID();
            $this->alertMessage = $alertModel->getAlertMessage();
            $this->title = $alertModel->getTitle();
            $this->visible = $alertModel->getVisible();
            $this->alerting = $alertModel->getAlerting();
            $this->dataID = $alertModel->getDataID();
            $this->dataType = $alertModel->getDataType();
        }
    }

    public function insertAlert(){
        profileAlertModel::insertAlert($this,"Insert");
    }

    public function updateAlert(){
        profileAlertModel::insertAlert($this,"Update");
    }

    public static function createReportAlert($profileName,$messageText,$reportID){
        $profileID = profileModel::getProfileIDFromName($profileName);
        if ($profileID != 0 && $profileID != "") {
            $alert = new profileAlertController("");
            $alert->setProfileID($profileID);
            $alert->setAlertMessage($messageText);
            $alert->setTitle("Report Resolved");
            $alert->setVisible(1);
            $alert->setAlerting(1);
            $alert->setDataType(1);
            $alert->setDataID($reportID);
            $alert->insertAlert();
            return array("ALERT" => "", "DATA" => "SUCCESS");
        } else {
            return array("ERROR"=>"Could not find profileID");
        }
    }

    public static function createNewAlert($profileName,$messageText,$messageTitle,$dataID){
        $profileID = profileModel::getProfileIDFromName($profileName);
        if ($profileID != 0 && $profileID != "") {
            $alert = new profileAlertController("");
            $alert->setProfileID($profileID);
            $alert->setAlertMessage($messageText);
            $alert->setTitle($messageTitle);
            $alert->setVisible(1);
            $alert->setAlerting(1);
            $alert->setDataType(1);
            $alert->setDataID($dataID);
            $alert->insertAlert();
        }
    }

    public static function getAllAlerts($profile){
        $list = profileAlertModel::getProfileAlerts($profile->getProfileID());
        $finalArray = [];
        $counter = 0;
        foreach ($list as $alert){
            if ($alert->getVisible() == 1){
                $temp = new profileAlertController($alert);
                $finalArray[$counter] = $temp->returnVars();
                $counter++;
            }
        }
        return $finalArray;
    }

    public static function markAsRead($profile,$alertArray){
        $alertArrayFormat = preg_replace(data::$cleanPatterns['special'],"",$alertArray);
        $alertArrayConvert = explode(",",$alertArrayFormat);
        if(is_array($alertArrayConvert)){
            $finalArray = [];
            foreach ($alertArrayConvert as $alert){
                $alertNum = intval($alert);
                profileAlertModel::alertRead($profile->getProfileID(),$alertNum);
            }
            return array("ALERT"=>"SUCCESS","DATA"=>$finalArray);
        } else {
            return array("ERROR"=>"Issue with array","DATA"=>$alertArrayConvert);
        }
    }

    public static function removeAlertVisible($profile,$alert){
        $alertClean = intval(preg_replace(data::$cleanPatterns['num'],"",$alert));
        profileAlertModel::alertGone($profile->getProfileID(),$alertClean);
        return array("ALERT"=>"SUCCESS","DATA"=>$alertClean);
    }
}