<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogMovementController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogMovement";
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

    public static function getAllMovementLogs($zoneID,$playersKnown,$day,$self){
        $chatLog = chatlogModel::getAllZoneActions("ChatlogMovement",$zoneID);
        $logDetailsObject = [];
        foreach ($chatLog as $log){
            if ($log->getAvatarID() == $self){
                $log->setAvatarID("you");
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

    public static function enterNewZone($avatarID,$direction){
        $log = new chatlogMovementController("");
        $directionNew = "ERROR";
        if ($direction === "n"){
            $directionNew = "south";
        } elseif ($direction === "s"){
            $directionNew = "north";
        } elseif ($direction === "e"){
            $directionNew = "west";
        } elseif ($direction === "w"){
            $directionNew = "east";
        }
        $message = "There are tracks suggesting that #name# came here from the ".$directionNew;
        $log->createNewLog($avatarID,$message);
        $log->insertChatLogZone();
    }


    public static function leaveCurrentZone($avatarID,$direction){
        $log = new chatlogMovementController("");
        $directionNew = "ERROR";
        if ($direction === "n"){
            $directionNew = "north";
        } elseif ($direction === "s"){
            $directionNew = "south";
        } elseif ($direction === "e"){
            $directionNew = "east";
        } elseif ($direction === "w"){
            $directionNew = "west";
        }
        $message = "The tracks suggest that #name# left the zone to the ".$directionNew;
        $log->createNewLog($avatarID,$message);
        $log->insertChatLogZone();
    }

    public static function playerJoinsMap($avatarID){
        $log = new chatlogMovementController("");
        $message = "The mess is all that's left to show that #name# lived here until recently";
        $log->createNewLog($avatarID,$message);
        $log->insertChatLogZone();
    }

    public static function destroyBiome($avatarID){
        $log = new chatlogMovementController("");
        $message = "A huge explosion appears to have happened here, the only thing left is a burnt outline of #name#";
        $log->createNewLog($avatarID,$message);
        $log->insertChatLogZone();
    }

    public static function testing($avatarID){
        $log = new chatlogMovementController("");
        $message = "This is a testing script, please ignore it!!";
        $log->createNewLog($avatarID,$message);
        $log->insertChatLogZone();
    }
}