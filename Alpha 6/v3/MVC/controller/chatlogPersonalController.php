<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogPersonalController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogPersonal";
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

    public function createNewLog($avatar,$message,$messageType,$day){
        $this->mapID = $avatar->getMapID();
        $this->zoneID = $avatar->getZoneID();
        $this->avatarID = $avatar->getAvatarID();
        $this->mapDay = $day;
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
                    $logDetailsObject[$log->getMessageTimestamp()] = $log->returnVars();
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
                        $logDetailsObject[$log->getMessageTimestamp()] = $log->returnVars();
                    }
                }
            }
        }
        return $logDetailsObject;

    }

    public static function findNewResearch($avatar,$buildingName,$day)
    {
        $log = new chatlogPersonalController("");
        $message = "After much time spent studying you uncovered the designs for the <strong>" . $buildingName."</strong>";
        $messageType = 1;
        $log->createNewLog($avatar,$message,$messageType,$day);
        $log->insertChatLogZone();
    }

    public static function teachPlayerResearch($avatar,$buildingName,$playerName,$day)
    {
        $log = new chatlogPersonalController("");
        $message = "It took a while but <strong>".$playerName."</strong> seems to finally understand how to build the <strong>".$buildingName."</strong>";
        $messageType = 2;
        $log->createNewLog($avatar,$message,$messageType,$day);
        $log->insertChatLogZone();
    }

    public static function upgradeBackpack($avatar,$level,$day)
    {
        $log = new chatlogPersonalController("");
        $message = "You've managed to figure out how to expand your backpack, you are now the proud owner of the <strong>".$level."</strong>";
        $messageType = 3;
        $log->createNewLog($avatar,$message,$messageType,$day);
        $log->insertChatLogZone();
    }

    public static function shrineBonusItem($avatar,$shrineID,$day){
        $log = new chatlogPersonalController("");
        $shrine = new shrineController($shrineID);
        $item = new itemController("");
        $item->createBlankItem($shrine->getShrineBonusReward());
        $message = "You have been given a ".$item->getIdentity()." by ".$shrine->getShrineName();
        $messageType = 4;
        $log->createNewLog($avatar,$message,$messageType,$day);
        $log->insertChatLogZone();
    }

    public static function searchZone($avatar,$itemName,$day){
        $log = new chatlogPersonalController("");
        if ($itemName != "nothing"){
            $message = "After some tough searching you have managed to find a ##?".$itemName."##!";
            $messageType = 5;
        } else {
            $message = "Nothing was found when you searched the zone";
            $messageType = 8;
        }
        $log->createNewLog($avatar,$message,$messageType,$day);
        $log->insertChatLogZone();
    }

    public static function getFrozen($avatar,$day){
        $log = new chatlogPersonalController("");
        $message = "You couldn't keep yourself warm enough overnight and now you have frostbite!";
        $messageType = 9;
        $log->createNewLog($avatar,$message,$messageType,$day);
        $log->insertChatLogZone();
    }

}