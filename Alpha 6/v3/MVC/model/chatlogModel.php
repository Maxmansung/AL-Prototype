<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class chatlogModel extends chatlog
{

    private function __construct($chatModel)
    {
        $this->chatlogID = $chatModel['chatID'];
        $this->mapID = $chatModel['mapID'];
        $this->avatarID = intval($chatModel['avatarID']);
        $this->mapDay = intval($chatModel['mapDay']);
        $this->messageTime = intval($chatModel['messageTime']);
        $this->messageText = $chatModel['messageText'];
        if (isset($chatModel['groupID'])) {
            $this->groupID = intval($chatModel['groupID']);
        }
        $this->zoneID = intval($chatModel['zoneID']);
        $this->messageTimestamp = $chatModel['messageTime'];
        if (isset($chatModel['buildingID'])) {
            $this->buildingID = $chatModel['buildingID'];
        }
        if (isset($chatModel['otherVar'])) {
            $this->otherVar = $chatModel['otherVar'];
        }
        $this->messageType = intval($chatModel['messageType']);
    }

    public static function insertChatLogZone($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        $chatID = intval($chatController->getChatlogID());
        $mapID = $chatController->getMapID();
        $zoneID = intval($chatController->getZoneID());
        $avatarID = intval($chatController->getAvatarID());
        $mapDay = intval($chatController->getMapDay());
        $messageTime = $chatController->getMessageTime();
        $messageText = $chatController->getMessageText();
        $messageType = intval($chatController->getMessageType());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (mapID, zoneID, avatarID, mapDay, messageTime, messageText, messageType) VALUES (:mapID, :zoneID, :avatarID, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, zoneID= :zoneID, avatarID= :avatarID, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
            $req->bindParam(':chatID',$chatID);
        }
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':avatarID', $avatarID);
        $req->bindParam(':mapDay', $mapDay);
        $req->bindParam(':messageTime',$messageTime);
        $req->bindParam(':messageText', $messageText);
        $req->bindParam(':messageType', $messageType);
        $req->execute();
    }

    public static function insertChatLogGroup($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        $chatID = intval($chatController->getChatlogID());
        $mapID =intval($chatController->getMapID());
        $groupID = intval($chatController->getGroupID());
        $avatarID = $chatController->getAvatarID();
        $mapDay = intval($chatController->getMapDay());
        $messageTime = intval($chatController->getMessageTime());
        $messageText = $chatController->getMessageText();
        $messageType = intval($chatController->getMessageType());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (mapID, groupID, avatarID, mapDay, messageTime, messageText, messageType) VALUES (:mapID, :groupID, :avatarID, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, groupID= :groupID, avatarID= :avatarID, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
            $req->bindParam(':chatID', $chatID);
        }
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':groupID', $groupID);
        $req->bindParam(':avatarID', $avatarID);
        $req->bindParam(':mapDay', $mapDay);
        $req->bindParam(':messageTime', $messageTime);
        $req->bindParam(':messageText', $messageText);
        $req->bindParam(':messageType', $messageType);
        $req->execute();
    }

    public static function insertChatLogBuilding($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        $chatID = intval($chatController->getChatlogID());
        $mapID =intval($chatController->getMapID());
        $zoneID = intval($chatController->getZoneID());
        $buildingID = $chatController->getBuildingID();
        $mapDay = intval($chatController->getMapDay());
        $messageTime = intval($chatController->getMessageTime());
        $messageText = $chatController->getMessageText();
        $messageType = intval($chatController->getMessageType());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (mapID, zoneID, buildingID, mapDay, messageTime, messageText, messageType) VALUES (:mapID, :zoneID, :buildingID, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, zoneID= :zoneID, buildingID= :buildingID, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
            $req->bindParam(':chatID', $chatID);
        }
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':buildingID', $buildingID);
        $req->bindParam(':mapDay', $mapDay);
        $req->bindParam(':messageTime', $messageTime);
        $req->bindParam(':messageText', $messageText);
        $req->bindParam(':messageType', $messageType);
        $req->execute();
    }

    public static function insertChatlogOther($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        $chatID = intval($chatController->getChatlogID());
        $mapID =intval($chatController->getMapID());
        $zoneID = intval($chatController->getZoneID());
        $otherVar = $chatController->getOtherVar();
        $mapDay = intval($chatController->getMapDay());
        $messageTime = intval($chatController->getMessageTime());
        $messageText = $chatController->getMessageText();
        $messageType = intval($chatController->getMessageType());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (mapID, zoneID, otherVar, mapDay, messageTime, messageText, messageType) VALUES (:mapID, :zoneID, :otherVar, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, zoneID= :zoneID, otherVar= :otherVar, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
            $req->bindParam(':chatID', $chatID);
        }
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':otherVar', $otherVar);
        $req->bindParam(':mapDay', $mapDay);
        $req->bindParam(':messageTime', $messageTime);
        $req->bindParam(':messageText', $messageText);
        $req->bindParam(':messageType', $messageType);
        $req->execute();
    }

    public static function getChatLogByID($chatlogID,$type){
            $db = db_conx::getInstance();
            $req = $db->prepare('SELECT * FROM '.$type.' WHERE chatID= :chatID LIMIT 1');
            $req->bindParam(':chatID', $chatlogID);
            $req->execute();
            $chatLogModel = $req->fetch();
            return new chatlogModel($chatLogModel);
    }


    public static function getAllZoneActions($type, $zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM '.$type.' WHERE zoneID= :zoneID ORDER BY messageTime');
        $req->bindParam(':zoneID',$zoneID);
        $req->execute();
        $logArray = $req->fetchAll();
        $counter = 0;
        $logModelArray = [];
        foreach ($logArray as $log){
            $tempLog = new chatlogModel($log);
            $tempLog->setChatlogType($type);
            $logModelArray[$counter] = $tempLog;
            $counter += 1;
        }
        return $logModelArray;
    }



    public static function getAllGroupActions($type, $groupID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM '.$type.' WHERE groupID= :groupID ORDER BY messageTime');
        $req->bindParam(':groupID',$groupID);
        $req->execute();
        $logArray = $req->fetchAll();
        $counter = 0;
        $logModelArray = [];
        foreach ($logArray as $log){
            $tempLog = new chatlogModel($log);
            $tempLog->setChatlogType($type);
            $logModelArray[$counter] = $tempLog;
            $counter += 1;
        }
        return $logModelArray;
    }


    public static function getAllPersonalActions($type, $avatarID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM '.$type.' WHERE avatarID= :avatarID ORDER BY messageTime');
        $req->bindParam(':avatarID',$avatarID);
        $req->execute();
        $logArray = $req->fetchAll();
        $counter = 0;
        $logModelArray = [];
        foreach ($logArray as $log){
            $tempLog = new chatlogModel($log);
            $tempLog->setChatlogType($type);
            $logModelArray[$counter] = $tempLog;
            $counter += 1;
        }
        return $logModelArray;
    }


    public static function getAllWorldActions($type, $mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM '.$type.' WHERE mapID= :mapID ORDER BY messageTime');
        $req->bindParam(':mapID',$mapID);
        $req->execute();
        $logArray = $req->fetchAll();
        $counter = 0;
        $logModelArray = [];
        foreach ($logArray as $log){
            $tempLog = new chatlogModel($log);
            $tempLog->setChatlogType($type);
            $logModelArray[$counter] = $tempLog;
            $counter += 1;
        }
        return $logModelArray;
    }

    //This deletes all the logs related to a group
    public static function deleteAllGroupLogs($type,$groupID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM '.$type.' WHERE groupID= :groupID');
        $req->bindParam(':groupID',$groupID);
        $req->execute();
    }

}