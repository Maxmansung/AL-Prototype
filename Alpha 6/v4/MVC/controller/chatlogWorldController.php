<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogWorldController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogWorld";
        if ($id != ""){
            if (is_object($id)){
                $chatLogModel = $id;
            } else {
                $chatLogModel =chatlogModel::getChatLogByID($id, $this->chatlogType);
            }
            $this->chatlogID = $chatLogModel->getChatlogID();
            $this->mapID = $chatLogModel->getMapID();
            $this->zoneID = $chatLogModel->getZoneID();
            $this->otherVar = $chatLogModel->getOtherVar();
            $this->mapDay = $chatLogModel->getMapDay();
            $this->messageTime = $chatLogModel->getMessageTime();
            $this->messageText = $chatLogModel->getMessageText();
            $this->messageTimestamp = $chatLogModel->getMessageTimestamp();
            $this->messageType = $chatLogModel->getMessageType();
        }
    }

    public function createNewLog($zone,$otherVar,$message,$currentDay){
        $this->mapID = $zone->getMapID();
        $this->zoneID = $zone->getZoneID();
        $this->otherVar = $otherVar;
        $this->mapDay = $currentDay;
        $this->messageTime = time();
        $this->messageText = $message;
    }

    public static function getAllWorldLogs($mapID,$day)
    {
        $chatLog = chatlogModel::getAllWorldActions("ChatlogWorld", $mapID);
        $logDetailsObject = [];
        foreach ($chatLog as $log) {
            if ($log->getMapDay() === intval($day)) {
                $log->createMessageTime();
                $logDetailsObject[$log->getMessageTimestamp()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function shrineBonusGained($zone,$day){
        $log = new chatlogWorldController("");
        $name = "shrine".$zone->getProtectedType();
        $shrine = new $name();
        $message = $shrine->getBlessingMessage();
        $log->createNewLog($zone,$shrine->getShrineType(),$message,$day);
        $log->insertChatLogWorld();
    }

}