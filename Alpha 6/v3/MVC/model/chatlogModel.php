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
        $this->groupID = $chatModel['groupID'];
        $this->zoneID = intval($chatModel['zoneID']);
        $this->messageTimestamp = $chatModel['messageTime'];
        $this->buildingID = $chatModel['buildingID'];
        $this->otherVar = $chatModel['otherVar'];
        $this->messageType = intval($chatModel['messageType']);
    }

    public static function insertChatLogZone($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (chatID, mapID, zoneID, avatarID, mapDay, messageTime, messageText, messageType) VALUES (:chatID, :mapID, :zoneID, :avatarID, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, zoneID= :zoneID, avatarID= :avatarID, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
        }
        $req->bindParam(':chatID', intval($chatController->getChatlogID()));
        $req->bindParam(':mapID', $chatController->getMapID());
        $req->bindParam(':zoneID', intval($chatController->getZoneID()));
        $req->bindParam(':avatarID', intval($chatController->getAvatarID()));
        $req->bindParam(':mapDay', intval($chatController->getMapDay()));
        $req->bindParam(':messageTime', $chatController->getMessageTime());
        $req->bindParam(':messageText', $chatController->getMessageText());
        $req->bindParam(':messageType', intval($chatController->getMessageType()));
        $req->execute();
    }

    public static function insertChatLogGroup($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (chatID, mapID, groupID, avatarID, mapDay, messageTime, messageText, messageType) VALUES (:chatID, :mapID, :groupID, :avatarID, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, groupID= :groupID, avatarID= :avatarID, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
        }
        $req->bindParam(':chatID', intval($chatController->getChatlogID()));
        $req->bindParam(':mapID', $chatController->getMapID());
        $req->bindParam(':groupID', $chatController->getGroupID());
        $req->bindParam(':avatarID', $chatController->getAvatarID());
        $req->bindParam(':mapDay', intval($chatController->getMapDay()));
        $req->bindParam(':messageTime', $chatController->getMessageTime());
        $req->bindParam(':messageText', $chatController->getMessageText());
        $req->bindParam(':messageType', intval($chatController->getMessageType()));
        $req->execute();
    }

    public static function insertChatLogBuilding($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (chatID, mapID, zoneID, buildingID, mapDay, messageTime, messageText, messageType) VALUES (:chatID, :mapID, :zoneID, :buildingID, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, zoneID= :zoneID, buildingID= :buildingID, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
        }
        $req->bindParam(':chatID', intval($chatController->getChatlogID()));
        $req->bindParam(':mapID', $chatController->getMapID());
        $req->bindParam(':zoneID', $chatController->getZoneID());
        $req->bindParam(':buildingID', $chatController->getBuildingID());
        $req->bindParam(':mapDay', intval($chatController->getMapDay()));
        $req->bindParam(':messageTime', $chatController->getMessageTime());
        $req->bindParam(':messageText', $chatController->getMessageText());
        $req->bindParam(':messageType', intval($chatController->getMessageType()));
        $req->execute();
    }

    public static function insertChatlogOther($chatController, $type){
        $chatlogType = $chatController->getChatlogType();
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO ".$chatlogType." (chatID, mapID, zoneID, otherVar, mapDay, messageTime, messageText, messageType) VALUES (:chatID, :mapID, :zoneID, :otherVar, :mapDay, :messageTime, :messageText, :messageType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE  ".$chatlogType."  SET mapID= :mapID, zoneID= :zoneID, otherVar= :otherVar, mapDay= :mapDay, messageTime= :messageTime, messageText= :messageText WHERE chatID= :chatID");
        }
        $req->bindParam(':chatID', intval($chatController->getChatlogID()));
        $req->bindParam(':mapID', $chatController->getMapID());
        $req->bindParam(':zoneID', $chatController->getZoneID());
        $req->bindParam(':otherVar', $chatController->getOtherVar());
        $req->bindParam(':mapDay', intval($chatController->getMapDay()));
        $req->bindParam(':messageTime', $chatController->getMessageTime());
        $req->bindParam(':messageText', $chatController->getMessageText());
        $req->bindParam(':messageType', intval($chatController->getMessageType()));
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

    //This returns the next value in the counter columnn in order to add to the new item information
    public static function createMessageID($type){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT chatID FROM '.$type.' ORDER BY chatID DESC LIMIT 1');
        $req->execute();
        $tempID = $req->fetch();
        return $tempID['chatID']+1;
    }


    public static function getAllZoneActions($type, $zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM '.$type.' WHERE zoneID= :zoneID ORDER BY messageTime');
        $req->bindParam(':zoneID',$zoneID);
        $req->execute();
        $logArray = $req->fetchAll();
        $counter = 0;
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