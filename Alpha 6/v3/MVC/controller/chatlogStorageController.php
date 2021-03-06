<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogStorageController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogStorage";
        if ($id != ""){
            if (is_object($id)){
                $chatLogModel = $id;
            } else {
                $chatLogModel =chatlogModel::getChatLogByID($id, $this->chatlogType);
            }
            $this->chatlogID = $chatLogModel->getChatlogID();
            $this->mapID = $chatLogModel->getMapID();
            $this->zoneID = $chatLogModel->getZoneID();
            $this->avatarID = $chatLogModel->getAvatarID();
            $this->mapDay = $chatLogModel->getMapDay();
            $this->messageTime = $chatLogModel->getMessageTime();
            $this->messageText = $chatLogModel->getMessageText();
            $this->messageTimestamp = $chatLogModel->getMessageTimestamp();
            $this->buildingID = $chatLogModel->getBuildingID();
            $this->messageType = $chatLogModel->getMessageType();
        }
    }

    public function createNewLog($avatar,$message,$currentDay){
        $this->mapID = $avatar->getMapID();
        $this->zoneID = $avatar->getZoneID();
        $this->avatarID = $avatar->getAvatarID();
        $this->mapDay = $currentDay;
        $this->messageTime = time();
        $this->messageText = $message;
    }

    public static function getAllStorageLogs($zoneID,$playersKnown,$day,$self){
        $chatLog = chatlogModel::getAllZoneActions("ChatlogStorage",$zoneID);
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
                $logDetailsObject[$log->getMessageTimestamp()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function dropInStorage($avatar,$itemName,$day){
        $log = new chatlogStorageController("");
        $message = "#name# put a <span class='itemLogName'>".$itemName."</span> into the storage";
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }

    public static function takeFromStorage($avatar,$itemName,$day){
        $log = new chatlogStorageController("");
        $message = "#name# took a <span class='itemLogName'>".$itemName."</span> out of the storage";
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }

    public static function upgradeStorage($avatar,$storageLevel,$day){
        $log = new chatlogStorageController("");
        $message = "The storage was upgraded to <strong>Level ".$storageLevel."</strong> by #name#";
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }
}