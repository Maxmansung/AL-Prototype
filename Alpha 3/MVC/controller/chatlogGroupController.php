<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyController.php");
class chatlogGroupController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogGroup";
        if ($id != ""){
            $chatLogModel = chatlogModel::getChatLogByID($id,$this->chatlogType);
            $this->chatlogID = $chatLogModel->getChatlogID();
            $this->mapID = $chatLogModel->getMapID();
            $this->groupID = $chatLogModel->getGroupID();
            $this->avatarID = $chatLogModel->getAvatarID();
            $this->mapDay = $chatLogModel->getMapDay();
            $this->messageTime = $chatLogModel->getMessageTime();
            $this->messageText = $chatLogModel->getMessageText();
            $this->messageTimestamp = $chatLogModel->getMessageTimestamp();
            $this->buildingID = $chatLogModel->getBuildingID();
        }
    }

    public function createNewLog($avatarID,$message,$partyID){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $this->chatlogID = $this->getNewID($this->chatlogType);
        $this->mapID = $avatar->getMapID();
        $this->groupID = $partyID;
        $this->avatarID = $avatar->getAvatarID();
        $this->mapDay = $map->getCurrentDay();
        $this->messageTime = time();
        $this->messageText = $message;
    }

    public static function getAllGroupLogs($groupID,$day,$playersKnown){
        $chatLog = chatlogModel::getAllGroupActions("ChatlogGroup",$groupID);
        $logDetailsObject = [];
        foreach ($chatLog as $log){
            if (!in_array($log->getAvatarID(), $playersKnown)) {
                $log->setAvatarID("Someone");
            } else {
                $log->setAvatarID(str_replace($log->getMapID(), "", $log->getAvatarID()));
            }
            if ($log->getMapDay() === intval($day)) {
                $log->createMessageTime();
                $logDetailsObject[$log->getChatlogID()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function playerJoining($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has requested to join the party";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function playerKicking($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "A vote has been started to kick #name# from the party";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function joinSuccess($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has successfully been added to the party, lets make them feel welcome!";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function kickSuccess($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "The vote to kick #name# has failed, maybe you should discuss before you vote?";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function joinFail($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "The request for #name# to join the party has been rejected";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function kickFail($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has been forcefully removed from the party, took you long enough...";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function leaveGroup($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has decided to leave the party, did someone do something to upset them?";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function cancelGroupRequest($avatarID,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# given up waiting to join the group";
        $log->createNewLog($avatarID,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function deleteGroupLogs($groupID){
        chatlogModel::deleteAllGroupLogs("ChatlogGroup",$groupID);
    }

}