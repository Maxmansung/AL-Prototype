<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
class chatlogFirepitController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogFirepit";
        if ($id != ""){
            $chatLogModel = chatlogModel::getChatLogByID($id,$this->chatlogType);
            $this->chatlogID = $chatLogModel->getChatlogID();
            $this->mapID = $chatLogModel->getMapID();
            $this->zoneID = $chatLogModel->getZoneID();
            $this->avatarID = $chatLogModel->getAvatarID();
            $this->mapDay = $chatLogModel->getMapDay();
            $this->messageTime = $chatLogModel->getMessageTime();
            $this->messageText = $chatLogModel->getMessageText();
            $this->messageTimestamp = $chatLogModel->getMessageTimestamp();
            $this->buildingID = $chatLogModel->getBuildingID();
        }
    }

    public function createNewLog($avatarID,$message){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $this->chatlogID = $this->getNewID($this->chatlogType);
        $this->mapID = $avatar->getMapID();
        $this->zoneID = $avatar->getZoneID();
        $this->avatarID = $avatar->getAvatarID();
        $this->mapDay = $map->getCurrentDay();
        $this->messageTime = time();
        $this->messageText = $message;
    }

    public static function getAllFirepitLogs($zoneID,$playersKnown,$day,$self){
        $chatLog = chatlogModel::getAllZoneActions("ChatlogFirepit",$zoneID);
        $logDetailsObject = [];
        foreach ($chatLog as $log){
            if ($log->getAvatarID() == $self){
                $log->setAvatarID("You");
            } else {
                if (!in_array($log->getAvatarID(), $playersKnown)) {
                    $log->setAvatarID("Someone");
                } else {
                    $log->setAvatarID(str_replace($log->getMapID(), "", $log->getAvatarID()));
                }
            }
            if ($log->getMapDay() === intval($day)) {
                $log->createMessageTime();
                $logDetailsObject[$log->getChatlogID()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function dropInFirepit($avatarID,$itemName){
        $log = new chatlogFirepitController("");
        $message = "#name# dropped a <span class='itemLogName'>".$itemName."</span> into the firepit";
        $log->createNewLog($avatarID,$message);
        $log->insertChatLogZone();
    }
}