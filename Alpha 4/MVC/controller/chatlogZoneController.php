<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/buildingController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/zoneController.php");
class chatlogZoneController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogZone";
        if ($id != ""){
            $chatLogModel = chatlogModel::getChatLogByID($id, $this->chatlogType);
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

    public function createNewLog($zoneID,$buildingID,$message){
        $zone = new zoneController($zoneID);
        $map = new mapController($zone->getMapID());
        $this->chatlogID = $this->getNewID($this->chatlogType);
        $this->mapID = $zone->getMapID();
        $this->zoneID = $zone->getZoneID();
        $this->buildingID = $buildingID;
        $this->mapDay = $map->getCurrentDay();
        $this->messageTime = time();
        $this->messageText = $message;
    }

    public static function getAllZoneLogs($zoneID,$day,$self){
        $chatLog = chatlogModel::getAllZoneActions("ChatlogZone",$zoneID);
        $logDetailsObject = [];
        $avatar = new avatarController($self);
        $zone = new zoneController($zoneID);
        if ($zone->getControllingParty() == "empty" ||$zone->getControllingParty() == $avatar->getPartyID()) {
            foreach ($chatLog as $log) {
                if ($log->getMapDay() === intval($day)) {
                    $log->createMessageTime();
                    $logDetailsObject[$log->getChatlogID()] = $log->returnVars();
                }
            }
        }
        return $logDetailsObject;
    }

    public static function firepitDepleted($zoneID){
        $log = new chatlogZoneController("");
        $buildingID = buildingController::returnBuildingID("Firepit");
        $message = "The firepit has gone out! Who was meant to be watching it?";
        $log->createNewLog($zoneID,$buildingID,$message);
        $log->insertChatLogBuilding();
    }

    public static function lockDestroyed($zoneID,$buildingID){
        $log = new chatlogZoneController("");
        if ($buildingID == "B0005"){
            $message = "The fence has been broken down! All the riff-raff are getting in!";
        } elseif ($buildingID == "B0004"){
            $message = "The chest lock has been cracked! Protect the snowmen!";
        } else {
            $message = "ERROR - Please bug report (Breaking a lock ID does not match up";
        }
        $log->createNewLog($zoneID,$buildingID,$message);
        $log->insertChatLogBuilding();
    }

    public static function buildingCompleted($zoneID,$buildingID){
        $log = new chatlogZoneController("");
        $building = new buildingController("");
        $building->createNewBuilding($buildingID,$zoneID);
        $message = "A new ".$building->getName()." has been created in this zone";
        $log->createNewLog($zoneID,$buildingID,$message);
        $log->insertChatLogBuilding();
    }

}