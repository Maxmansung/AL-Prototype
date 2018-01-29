<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/controller/privateMessages.php");
require_once(PROJECT_ROOT."/MVC/model/privateMessagesModel.php");
class privateMessagesController extends privateMessages
{

    function __construct($messageID)
    {
        if ($messageID != "") {
            $messageModel = privateMessagesModel::findMessage($messageID);
            $this->messageID = $messageModel->messageID;
            $this->receivingAvatar = $messageModel->receivingAvatar;
            $this->sendingAvatar = $messageModel->sendingAvatar;
            $this->gameTimestamp = $messageModel->gameTimestamp;
            $this->messageTitle = $messageModel->messageTitle;
            $this->messageText = $messageModel->messageText;
        }

    }


    public static function createNewMessage($sendingAvatar, $receivingAvatar, $messageTitle, $messageText)
    {
        $sender = new avatarController($sendingAvatar);
        $receiver = new avatarController($receivingAvatar);
        if ($sender->getAvatarID() == "" || $receiver->getAvatarID() == "") {
            return array("ERROR" => "One or more of the avatars do not exist");
        } else {
            if ($sender->getZoneID() !== $receiver->getZoneID()) {
                return array("ERROR" => "Both players are not in the same zone and so cannot message");
            } else {
                $privateMessage = new privateMessagesController("");
                $privateMessage->setReceivingAvatar($receiver->getAvatarID());
                $privateMessage->setSendingAvatar($sender->getAvatarID());
                if (strlen($messageTitle) < 2) {
                    return array("ERROR" => "The message title is too short");
                } else {
                    if (strlen($messageTitle) > 30) {
                        return array("ERROR" => "The message title is too long");
                    } else {
                        $privateMessage->setMessageTitle(preg_replace('#[^A-Za-z0-9 !?\-_()@:,."]#i', '', $messageTitle));
                        if (strlen($messageText) < 3) {
                            return array("ERROR" => "The message text is too short");
                        } else {
                            if (strlen($messageText) > 1000) {
                                return array("ERROR" => "The message text is too long");
                            } else {
                                $privateMessage->setMessageText(htmlentities($messageText, ENT_QUOTES | ENT_SUBSTITUTE));
                                $privateMessage->autoTimeStamp();
                                $privateMessage->insertMessage();
                                return array("ALERT"=>10,"DATA"=>$receiver->getProfileID());
                            }
                        }
                    }
                }
            }
        }
    }

    public static function getAllSent($avatarID, $type){
        $tempArray = privateMessagesModel::getSentMessages($avatarID);
        $finalArray = [];
        $counter = 0;
        if ($type === "view"){
            foreach ($tempArray as $messageID){
                $message = new privateMessagesController($messageID);
                $message->convertTimestamp();
                $message->convertMessageSender("sent");
                $finalArray[$counter."a"] = $message->returnVars();
                $counter++;
            }
        }
        ksort($finalArray);
        return $finalArray;
    }

    public static function getAllReceived($avatarID, $type){
        $tempArray = privateMessagesModel::getReceivedMessages($avatarID);
        $finalArray = [];
        if ($type === "view"){
            foreach ($tempArray as $messageID){
                $message = new privateMessagesController($messageID);
                $message->convertTimestamp();
                $message->convertMessageSender("received");
                $finalArray[$message->getMessageID()] = $message->returnVars();
            }
        }
        ksort($finalArray);
        return $finalArray;
    }


    public function uploadMessage(){
        privateMessagesModel::insertMessage($this,"Update");
    }

    public function insertMessage(){
        privateMessagesModel::insertMessage($this,"Insert");
    }

    private function convertTimestamp(){
        $timer = date("jS M G:i",$this->getTimeStamp());
        $this->setTimeStamp($timer);
    }

    private function convertMessageSender($type){
        if ($type === "received") {
            $avatar = new avatarController($this->getSendingAvatar());
        } else {
            $avatar = new avatarController($this->getReceivingAvatar());
        }
        $this->otherPlayer = $avatar->getProfileID();
    }


}