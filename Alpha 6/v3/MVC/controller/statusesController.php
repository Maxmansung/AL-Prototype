<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/statuses.php");
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
            $statusArray[1] = 0;
            $statusArray[2] = 0;
            $statusArray[5] = 0;
        } elseif ($statusArray[2] === 1){
            $statusArray[1] = 0;
            $statusArray[2] = 1;
            $statusArray[5] = 0;
        } else {
            $statusArray[1] = 1;
            $statusArray[2] = 0;
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
        $response = responseController::getStatusChangeType($statusEffect);
        if (in_array($response->getFailStatus(),$statusArray) || $response->getFailStatus() === false){
            if (!in_array($response->getSucceedStatus(),$statusArray) || $response->getSucceedStatus() === false){
                return $response->getFailResponse();
            }
        }
        return true;
    }

    public static function getStatusResponseSucceed($response){
        $response = responseController::getStatusChangeType($response);
        return $response->getSucceedResponse();
    }

}