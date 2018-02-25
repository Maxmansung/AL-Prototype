<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class privateMessagesModel extends privateMessages
{
    private function __construct($messageModel)
    {
        $this->messageID = $messageModel['messageID'];
        $this->receivingAvatar = $messageModel['receivingAvatar'];
        $this->sendingAvatar = $messageModel['sendingAvatar'];
        $this->gameTimestamp = $messageModel['gameTimestamp'];
        $this->messageTitle = $messageModel['messageTitle'];
        $this->messageText = $messageModel['messageText'];
    }

    public static function findMessage($messageID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM privateMessages WHERE messageID= :messageID LIMIT 1');
        $req->execute(array(':messageID' => $messageID));
        $messageModel = $req->fetch();
        return new privateMessagesModel($messageModel);
    }


    public static function insertMessage($controller, $type){
        $db = db_conx::getInstance();
        $null = null;
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO privateMessages (messageID, receivingAvatar, sendingAvatar, gameTimestamp, messageTitle, messageText) VALUES (:messageID, :receivingAvatar, :sendingAvatar, :gameTimestamp, :messageTitle, :messageText)");
            $req->bindParam(':messageID', $null,PDO::PARAM_NULL);
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE privateMessages SET receivingAvatar= :receivingAvatar, sendingAvatar= :sendingAvatar, gameTimestamp= :gameTimestamp, messageTitle= :messageTitle, messageText= :messageText WHERE messageID= :messageID");
            $req->bindParam(':messageID', $controller->getMessageID());
        }
        $req->bindParam(':messageID', $controller->getMessageID());
        $req->bindParam(':receivingAvatar', $controller->getReceivingAvatar());
        $req->bindParam(':sendingAvatar', $controller->getSendingAvatar());
        $req->bindParam(':gameTimestamp', $controller->getTimeStamp());
        $req->bindParam(':messageTitle', $controller->getMessageTitle());
        $req->bindParam(':messageText', $controller->getMessageText());
        $req->execute();
    }

    public static function getSentMessages($senderID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM privateMessages WHERE sendingAvatar= :senderAvatar');
        $req->execute(array(':senderAvatar' => $senderID));
        $messageModel = $req->fetchAll();
        $finalArray = [];
        foreach ($messageModel as $message){
            array_push($finalArray,$message["messageID"]);
        }
        return $finalArray;
    }

    public static function getReceivedMessages($senderID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM privateMessages WHERE receivingAvatar= :receivingAvatar');
        $req->execute(array(':receivingAvatar' => $senderID));
        $messageModel = $req->fetchAll();
        $finalArray = [];
        foreach ($messageModel as $message){
            array_push($finalArray,$message["messageID"]);
        }
        return $finalArray;
    }

}