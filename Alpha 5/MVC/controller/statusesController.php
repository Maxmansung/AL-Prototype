<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/controller/statuses.php");
require_once(PROJECT_ROOT."/MVC/model/statusesModel.php");
class statusesController extends statuses
{
    public function __construct($id)
    {
        if ($id != ""){
            $status = statusesModel::getStatus($id);
            $this->statusID = $status->statusID;
            $this->statusName = $status->statusName;
            $this->statusDescription = $status->statusDescription;
            $this->statusImage = $status->statusImage;
            $this->statusModifier = $status->statusModifier;
            $this->startingStat = $status->startingStat;
        }
    }

    public static function createStatusArray(){
        return statusesModel::startingStats();
    }

    public static function changeStatuses($statusArray){
        if ($statusArray[1] === 1){
            $statusArray[1] = 0;
            $statusArray[2] = 1;
            $statusArray[5] = 0;
        } elseif ($statusArray[5] === 1){
            $statusArray[1] = 1;
            $statusArray[2] = 0;
            $statusArray[5] = 0;
        } elseif ($statusArray[2] === 1){
            $statusArray[1] = 0;
            $statusArray[2] = 1;
            $statusArray[5] = 0;
        }
        if ($statusArray[4] === 1) {
            $statusArray[4] = 0;
        }
        return $statusArray;
    }

    public static function checkStatuses($statusArray){
        if ($statusArray[2] === 1){
            return "dead";
        } elseif ($statusArray[3] === 1){
            return "risk";
        } else {
            return "safe";
        }
    }

    public static function checkConsumable($statusArray,$statusEffect){
        if ($statusEffect === 2) {
            if ($statusArray[5] === 1) {
                return statusesModel::getStatusResponse($statusEffect);
            }
        }
        if ($statusEffect === 3) {
            if ($statusArray[4] === 1) {
                return statusesModel::getStatusResponse($statusEffect);
            }
        }
        if ($statusEffect === 5){
            if($statusArray[5] === 1){
                return statusesModel::getStatusResponse($statusEffect);
            }
        }
        return true;
    }

    public static function changeStatusConsume($statusArray,$statusEffect){
        switch ($statusEffect){
            case 2:
                $statusArray[1] = 0;
                $statusArray[2] = 0;
                $statusArray[5] = 1;
                break;
            case 3:
                $statusArray[4] = 1;
                break;
            case 4:
                $statusArray[5] = 1;
                break;
            case 5:
                $chance = rand(0,1);
                if ($chance === 0){
                    $statusArray[1] = 0;
                    $statusArray[2] = 0;
                    $statusArray[5] = 1;
                }
        }
        return $statusArray;
    }

    public static function getStatusResponseSucceed($statusEffect){
        return statusesModel::getStatusResponseSucceed($statusEffect);
    }

}