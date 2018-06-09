<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/privateMessages_Interface.php");
class privateMessages implements privateMessages_Interface
{

    protected $messageID;
    protected $receivingAvatar;
    protected $sendingAvatar;
    protected $gameTimestamp;
    protected $messageTitle;
    protected $messageText;



    public function __toString()
    {
        $output = $this->messageID;
        $output .= '/ '.$this->receivingAvatar;
        $output .= '/ '.$this->sendingAvatar;
        $output .= '/ '.$this->gameTimestamp;
        $output .= '/ '.$this->messageTitle;
        $output .= '/ '.$this->messageText;
        return $output;
    }

    function returnVars()
    {
        return get_object_vars($this);
    }

    function getMessageID()
    {
        return $this->messageID;
    }

    function setMessageID($var)
    {
        $this->messageID = $var;
    }

    function getReceivingAvatar()
    {
        return $this->receivingAvatar;
    }

    function setReceivingAvatar($var)
    {
        $this->receivingAvatar = $var;
    }

    function getSendingAvatar()
    {
        return $this->sendingAvatar;
    }

    function setSendingAvatar($var)
    {
        $this->sendingAvatar = $var;
    }

    function getMessageTitle()
    {
        return $this->messageTitle;
    }

    function setMessageTitle($var)
    {
        $this->messageTitle = $var;
    }

    function getMessageText()
    {
        return $this->messageText;
    }

    function setMessageText($var)
    {
        $this->messageText = $var;
    }

    function autoTimeStamp(){
        $this->gameTimestamp = time();
    }

    function setTimeStamp($var){
        $this->gameTimestamp = $var;
    }

    function getTimeStamp(){
        return $this->gameTimestamp;
    }
}