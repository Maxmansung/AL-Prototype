<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogGroupController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogGroup";
        if ($id != ""){
            if (is_object($id)){
                $chatLogModel = $id;
            } else {
                $chatLogModel =chatlogModel::getChatLogByID($id, $this->chatlogType);
            }
            $this->chatlogID = $chatLogModel->getChatlogID();
            $this->mapID = $chatLogModel->getMapID();
            $this->groupID = $chatLogModel->getGroupID();
            $this->avatarID = $chatLogModel->getAvatarID();
            $this->mapDay = $chatLogModel->getMapDay();
            $this->messageTime = $chatLogModel->getMessageTime();
            $this->messageText = $chatLogModel->getMessageText();
            $this->messageTimestamp = $chatLogModel->getMessageTimestamp();
            $this->buildingID = $chatLogModel->getBuildingID();
            $this->messageType = $chatLogModel->getMessageType();
        }
    }

    public function createNewLog($avatar,$message,$partyID){
        $this->mapID = $avatar->getMapID();
        $this->groupID = $partyID;
        $this->avatarID = $avatar->getAvatarID();
        $this->mapDay = $avatar->getCurrentDay();
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
                $avatar = new avatarController($log->getAvatarID());
                $log->setAvatarID($avatar->getProfileID());
            }
            if ($log->getMapDay() === intval($day)) {
                $log->createMessageTime();
                $logDetailsObject[$log->getMessageTimestamp()] = $log->returnVars();
            }
        }
        return $logDetailsObject;
    }

    public static function playerJoining($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has requested to join the party";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function playerKicking($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "A vote has been started to kick #name# from the party";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function joinSuccess($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has successfully been added to the party, lets make them feel welcome!";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function kickSuccess($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "The vote to kick #name# has failed, maybe you should discuss before you vote?";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function joinFail($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "The request for #name# to join the party has been rejected";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function kickFail($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has been forcefully removed from the party, took you long enough...";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function leaveGroup($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# has decided to leave the party, did someone do something to upset them?";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function cancelGroupRequest($avatar,$groupID){
        $log = new chatlogGroupController("");
        $message = "#name# given up waiting to join the group";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function spiritBlessingGroup($avatar,$groupID,$shrineID){
        $log= new chatlogGroupController("");
        $name = "shrine".$shrineID;
        $shrine = new $name();
        $message = $shrine->getShrineName()." favours your tribe and has helped you all against the cold";
        $log->createNewLog($avatar,$message,$groupID);
        $log->insertChatLogGroup();
    }

    public static function deleteGroupLogs($groupID){
        chatlogModel::deleteAllGroupLogs("ChatlogGroup",$groupID);
    }

}