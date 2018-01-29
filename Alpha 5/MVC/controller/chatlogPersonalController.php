<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogPersonalController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogPersonal";
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
            $this->messageType = $chatLogModel->getMessageType();
        }
    }

    public function createNewLog($avatarID,$message,$messageType){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $this->chatlogID = $this->getNewID($this->chatlogType);
        $this->mapID = $avatar->getMapID();
        $this->zoneID = $avatar->getZoneID();
        $this->avatarID = $avatar->getAvatarID();
        $this->mapDay = $map->getCurrentDay();
        $this->messageTime = time();
        $this->messageText = $message;
        $this->messageType = $messageType;
    }

    public static function getAllPersonalLogs($day,$self){
        $chatLog = chatlogModel::getAllPersonalActions("ChatlogPersonal",$self);
        $logDetailsObject = [];
        $avatar = new avatarController($self);
        foreach ($chatLog as $log){
            if ($log->getMapDay() === intval($day)) {
                $skip = false;
                if ($log->getMessageType() === 5 || $log->getMessageType() === 8 ){
                    if ($avatar->getZoneID() !== $log->getZoneID()){
                        $skip = true;
                    }
                }
                if ($skip === false) {
                    $log->createMessageTime();
                    $logDetailsObject[$log->getChatlogID()] = $log->returnVars();
                }
            }
        }
        return $logDetailsObject;
    }

    public static function getAllSearchLogs($zoneID,$day,$avatarID){
        $chatLog = chatlogModel::getAllPersonalActions("ChatlogPersonal",$avatarID);
        $logDetailsObject = [];
        foreach ($chatLog as $log){
            if ($log->getMapDay() === intval($day)) {
                if ($log->getMessageType() === 5 || $log->getMessageType() === 8){
                    if ($zoneID === $log->getZoneID()){
                        $log->createMessageTime();
                        $logDetailsObject[$log->getChatlogID()] = $log->returnVars();
                    }
                }
            }
        }
        return $logDetailsObject;

    }

    public static function findNewResearch($avatarID,$buildingName)
    {
        $log = new chatlogPersonalController("");
        $message = "After much time spent studying you uncovered the designs for the <strong>" . $buildingName."</strong>";
        $messageType = 1;
        $log->createNewLog($avatarID,$message,$messageType);
        $log->insertChatLogZone();
    }

    public static function teachPlayerResearch($avatarID,$buildingName,$playerName)
    {
        $log = new chatlogPersonalController("");
        $message = "It took a while but <strong>".$playerName."</strong> seems to finally understand how to build the <strong>".$buildingName."</strong>";
        $messageType = 2;
        $log->createNewLog($avatarID,$message,$messageType);
        $log->insertChatLogZone();
    }

    public static function upgradeSleepingBag($avatarID,$level)
    {
        $log = new chatlogPersonalController("");
        $message = "You've spent some time reinforcing and padding out your sleeping bag, its now worthy of the title: <strong>Level ".$level."</strong>";
        $messageType = 3;
        $log->createNewLog($avatarID,$message,$messageType);
        $log->insertChatLogZone();
    }

    public static function upgradeBackpack($avatarID,$level)
    {
        $log = new chatlogPersonalController("");
        $message = "You've managed to figure out how to expand your backpack, it can now hold: <strong>".$level." Items</strong>";
        $messageType = 3;
        $log->createNewLog($avatarID,$message,$messageType);
        $log->insertChatLogZone();
    }

    public static function shrineBonusItem($avatarID,$shrineID){
        $log = new chatlogPersonalController("");
        $shrine = new shrineController($shrineID);
        $item = new itemController("");
        $item->createBlankItem($shrine->getShrineBonusReward());
        $message = "You have been given a ".$item->getIdentity()." by ".$shrine->getShrineName();
        $messageType = 4;
        $log->createNewLog($avatarID,$message,$messageType);
        $log->insertChatLogZone();
    }

    public static function searchZone($avatarID,$itemName){
        $log = new chatlogPersonalController("");
        if ($itemName != "nothing"){
            $message = "After some tough searching you have managed to find a ".$itemName;
            $messageType = 5;
        } else {
            $message = "Nothing was found when you searched the zone";
            $messageType = 8;
        }
        $log->createNewLog($avatarID,$message,$messageType);
        $log->insertChatLogZone();
    }

    public static function getFrozen($avatarID){
        $log = new chatlogPersonalController("");
        $message = "You couldn't keep yourself warm enough overnight and now you have frostbite!";
        $messageType = 9;
        $log->createNewLog($avatarID,$message,$messageType);
        $log->insertChatLogZone();
    }

}