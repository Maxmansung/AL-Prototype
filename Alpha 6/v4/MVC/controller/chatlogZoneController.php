<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogZoneController extends chatlogController
{

    public function __construct($id)
    {
        $this->chatlogType = "ChatlogZone";
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

    public function createNewLog($zone,$buildingID,$message,$currentDay){
        $this->mapID = $zone->getMapID();
        $this->zoneID = $zone->getZoneID();
        $this->buildingID = $buildingID;
        $this->mapDay = $currentDay;
        $this->messageTime = time();
        $this->messageText = $message;
    }

    public static function getAllZoneLogs($zoneID,$day,$self){
        $chatLog = chatlogModel::getAllZoneActions("ChatlogZone",$zoneID);
        $logDetailsObject = [];
        $avatar = new avatarController($self);
        $zone = new zoneController($zoneID);
        if ($zone->getControllingParty() == null ||$zone->getControllingParty() == $avatar->getPartyID()) {
            foreach ($chatLog as $log) {
                if ($log->getMapDay() === intval($day)) {
                    $log->createMessageTime();
                    $logDetailsObject[$log->getMessageTimestamp()] = $log->returnVars();
                }
            }
        }
        return $logDetailsObject;
    }

    public static function firepitDepleted($zone,$day){
        $log = new chatlogZoneController("");
        $buildingID = buildingController::returnBuildingID("Firepit");
        $message = "The firepit has gone out! Who was meant to be watching it?";
        $log->createNewLog($zone,$buildingID,$message,$day);
        $log->insertChatLogBuilding();
    }

    public static function lockDestroyed($zone,$buildingID,$day){
        $log = new chatlogZoneController("");
        if ($buildingID == "B0005"){
            $message = "The fence has been broken down! All the riff-raff are getting in!";
        } elseif ($buildingID == "B0004"){
            $message = "The chest lock has been cracked! Protect the snowmen!";
        } else {
            $message = "ERROR - Please bug report (Breaking a lock ID does not match up";
        }
        $log->createNewLog($zone,$buildingID,$message,$day);
        $log->insertChatLogBuilding();
    }

    public static function trapWorked($zone,$day){
        $log = new chatlogZoneController("");
        $buildingID = buildingController::returnBuildingID("Trap");
        $message = "There's a mouse in this trap! It actually worked!!";
        $log->createNewLog($zone,$buildingID,$message,$day);
        $log->insertChatLogBuilding();
    }

    public static function buildingCompleted($zone,$buildingID,$day){
        $log = new chatlogZoneController("");
        $building = new buildingController("");
        $building->createNewBuilding($buildingID,$zone->getZoneID());
        $message = "A new ".$building->getName()." has been created in this zone";
        $log->createNewLog($zone,$buildingID,$message,$day);
        $log->insertChatLogBuilding();
    }

    public static function smokeExpired($zone,$day){
        $log = new chatlogZoneController("");
        $buildingID = buildingController::returnBuildingID("Smoke");
        $message = "Only faint traces of smoke are left rising from the pit now";
        $log->createNewLog($zone,$buildingID,$message,$day);
        $log->insertChatLogBuilding();
    }

    public static function seedlingToScrub($zone,$day){
        $log = new chatlogZoneController("");
        $buildingID = buildingController::returnBuildingID("Seedling");
        $message = "It worked! You're slowly bringing the world back life. Small shrubs have started to grow";
        $log->createNewLog($zone,$buildingID,$message,$day);
        $log->insertChatLogBuilding();
    }

    public static function seedlingToForest($zone,$day){
        $log = new chatlogZoneController("");
        $buildingID = buildingController::returnBuildingID("Seedling");
        $message = "Were those magic beans? Already some small trees have sprouted up!";
        $log->createNewLog($zone,$buildingID,$message,$day);
        $log->insertChatLogBuilding();
    }

}