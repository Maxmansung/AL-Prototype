<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
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

    public static function getAllPersonalLogs($day,$self){
        $chatLog = chatlogModel::getAllPersonalActions("ChatlogPersonal",$self);
        $logDetailsObject = [];
        foreach ($chatLog as $log){
            if ($log->getMapDay() === intval($day)) {
                $log->createMessageTime();
                $logDetailsObject[$log->getChatlogID()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function findNewResearch($avatarID,$buildingName)
    {
        $log = new chatlogPersonalController("");
        $message = "After much time spent studying you uncovered the designs for the <strong>" . $buildingName."</strong>";
        $log->createNewLog($avatarID, $message);
        $log->insertChatLogZone();
    }

    public static function teachPlayerResearch($avatarID,$buildingName,$playerName)
    {
        $log = new chatlogPersonalController("");
        $message = "It took a while but <strong>".$playerName."</strong> seems to finally understand how to build the <strong>".$buildingName."</strong>";
        $log->createNewLog($avatarID, $message);
        $log->insertChatLogZone();
    }

    public static function upgradeSleepingBag($avatarID,$level)
    {
        $log = new chatlogPersonalController("");
        $message = "You've spent some time reinforcing and padding out your sleeping bag, its now worthy of the title: <strong>Level ".$level."</strong>";
        $log->createNewLog($avatarID, $message);
        $log->insertChatLogZone();
    }

    public static function shrineBonusItem($avatarID,$shrineID){
        $log = new chatlogPersonalController("");
        $shrine = new shrineController($shrineID);
        $item = new itemController("");
        $item->createBlankItem($shrine->getShrineBonusReward());
        $message = "You have been given a ".$item->getIdentity()." by ".$shrine->getShrineName();
        $log->createNewLog($avatarID,$message);
        $log->insertChatLogZone();
    }

}