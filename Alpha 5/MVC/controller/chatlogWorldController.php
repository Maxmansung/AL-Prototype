<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogWorldController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogWorld";
        if ($id != ""){
            $chatLogModel = chatlogModel::getChatLogByID($id, $this->chatlogType);
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

    public function createNewLog($zoneID,$otherVar,$message){
        $zone = new zoneController($zoneID);
        $map = new mapController($zone->getMapID());
        $this->chatlogID = $this->getNewID($this->chatlogType);
        $this->mapID = $zone->getMapID();
        $this->zoneID = $zone->getZoneID();
        $this->otherVar = $otherVar;
        $this->mapDay = $map->getCurrentDay();
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
                $logDetailsObject[$log->getChatlogID()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function shrineBonusGained($zoneID){
        $log = new chatlogWorldController("");
        $shrineID = shrineController::findShrine($zoneID);
        $shrine = new shrineController($shrineID);
        $message = $shrine->getBlessingMessage();
        $log->createNewLog($shrine->getZoneID(),$shrine->getShrineType(),$message);
        $log->insertChatLogWorld();
    }

}