<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/modTracking.php");
require_once(PROJECT_ROOT."/MVC/model/modTrackingModel.php");
class modTrackingController extends modTracking
{

    public function __construct($id)
    {
        if ($id != "") {
            if (is_object($id)) {
                $modModel = $id;
            } else {
                $modModel = modTrackingModel::getModTracking($id);
            }
            $this->trackID = $modModel->getTrackID();
            $this->actionType = $modModel->getActionType();
            $this->performedBy = $modModel->getPerformedBy();
            $this->timestampAction = $modModel->getTimestampAction();
            $this->details1 = $modModel->getDetails1();
            $this->details2 = $modModel->getDetails2();
        }
    }

    public function insertModTrack(){
        modTrackingModel::insertModTrack($this,"Insert");
    }

    public function updateModTrack(){
        modTrackingModel::insertModTrack($this,"Update");
    }

    public static function createNewTrack($actionType,$profileID,$details1,$details2,$details3,$details4){
        $mod = new modTrackingController("");
        $mod->setActionType($actionType);
        $mod->setPerformedBy($profileID);
        $mod->createDetails($details1,$details2,$details3,$details4);
        $mod->setTimestampAction(time());
        $mod->insertModTrack();
    }

    private function createDetails($details1,$details2,$details3,$details4){
        $type = $this->getActionType();
        switch ($type){
            case 1:
                $info1 = "Map type: ".$details1;
                $info2 = "Name: ".$details2;
                break;
            case 2:
                $info1 = "Report: ".$details1;
                $info2 = "";
                break;
            case 3:
                $info1 = "NewsID: ".$details1;
                $info2 = "Title: ".$details2;
                break;
            case 4:
                $info1 = $details1;
                $info2 = "";
                break;
            case 5:
                $info1 = "Map: ".$details1;
                $info2 = "Type: ".$details2;
                break;
            case 6:
                $info1 = "Players to: ".$details1." from: ".$details2;
                $info2 = "Temp to: ".$details3." from: ".$details4;
                break;
            case 7:
                $info1 = "Profile: ".$details1;
                $info2 = "Map: ".$details2;
                break;
            case 8:
                $info1 = "Stamina to: ".$details1." from: ".$details2;
                $info2 = "Temp to: ".$details3." from: ".$details4;
                break;
            case 9:
                $info1 = "Profile: ".$details1;
                $info2 = "Rank to: ".$details2." from: ".$details3;
                break;
            case 10:
                $info1 = "Profile: ".$details1;
                $info2 = "Warning: ".$details2;
                break;
            case 11:
                $info1 = "Post: ".$details1;
                $info2 = "Type: ".$details2;
                break;
            case 12:
                $info1 = "Comment: ".$details1;
                $info2 = "Type: ".$details2;
                break;
            default:
                $info1 = "";
                $info2 = "";
                break;
        }
        $this->setDetails1($info1);
        $this->setDetails2($info2);

    }

}