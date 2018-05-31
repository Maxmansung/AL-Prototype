<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogMovementController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogMovement";
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
                    $avatar = new avatarController($log->getAvatarID());
                    $log->setAvatarID($avatar->getProfileID());
                }
            }
            if ($log->getMapDay() === intval($day)) {
                $log->createMessageTime();
                $logDetailsObject[$log->getMessageTimestamp()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function enterNewZone($avatar,$direction,$day){
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
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }


    public static function leaveCurrentZone($avatar,$direction,$day){
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
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }

    public static function playerJoinsMap($avatar,$day){
        $log = new chatlogMovementController("");
        $message = "The mess is all that's left to show that #name# lived here until recently";
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }

    public static function destroyBiome($avatar,$day){
        $log = new chatlogMovementController("");
        $message = "A huge explosion appears to have happened here, the only thing left is a burnt outline of #name#";
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }

    public static function testing($avatar,$day){
        $log = new chatlogMovementController("");
        $message = "This is a testing script, please ignore it!!";
        $log->createNewLog($avatar,$message,$day);
        $log->insertChatLogZone();
    }
}