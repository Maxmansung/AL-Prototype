<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/interface/chatlog_Interface.php");
class chatlog implements chatlog_Interface
{

    protected $chatlogID;
    protected $mapID;
    protected $zoneID;
    protected $avatarID;
    protected $mapDay;
    protected $messageTime;
    protected $messageText;
    protected $chatlogType;
    protected $groupID;
    protected $buildingID;
    protected $messageTimestamp;
    protected $otherVar;
    protected $messageType;


    public function __toString()
    {
        $output = $this->chatlogID;
        $output .= '/ '.$this->mapID;
        $output .= '/ '.$this->zoneID;
        $output .= '/ '.$this->avatarID;
        $output .= '/ '.$this->mapDay;
        $output .= '/ '.$this->messageTime;
        $output .= '/ '.$this->messageText;
        $output .= '/ '.$this->chatlogType;
        $output .= '/ '.$this->groupID;
        $output .= '/ '.$this->buildingID;
        $output .= '/ '.$this->messageTimestamp;
        $output .= '/ '.$this->otherVar;
        return $output;
    }

    public function returnVars(){
        return get_object_vars($this);
    }

    function getChatlogID()
    {
        return $this->chatlogID;
    }

    function setChatlogID($var)
    {
        $this->chatlogID = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getZoneID()
    {
        return $this->zoneID;
    }

    function setZoneID($var)
    {
        $this->zoneID = $var;
    }

    function getAvatarID()
    {
        return $this->avatarID;
    }

    function setAvatarID($var)
    {
       $this->avatarID = $var;
    }

    function getMapDay()
    {
       return $this->mapDay;
    }

    function setMapDay($var)
    {
        $this->mapDay = $var;
    }

    function getMessageTime()
    {
        return $this->messageTime;
    }

    function setMessageTime($var)
    {
        $this->messageTime = $var;
    }

    function getMessageText()
    {
        return $this->messageText;
    }

    function setMessageText($var)
    {
        $this->messageText = $var;
    }

    function getChatlogType()
    {
        return $this->chatlogType;
    }

    function setChatlogType($var)
    {
        $this->chatlogType = $var;
    }

    function createMessageTime(){
        date_default_timezone_set("Europe/London");
        $this->messageTime = date("H:i",$this->messageTime);
    }

    function getGroupID(){
        return $this->groupID;
    }

    function setGroupID($var){
        $this->groupID = $var;
    }

    function getMessageTimestamp()
    {
        return $this->messageTimestamp;
    }

    function setMessageTimestamp($var)
    {
        $this->messageTimestamp = $var;
    }

    function getBuildingID()
    {
        return $this->buildingID;
    }

    function setBuildingID($var)
    {
        $this->buildingID = $var;
    }

    function getOtherVar()
    {
        return $this->otherVar;
    }

    function setOtherVar($var)
    {
        $this->otherVar = $var;
    }

    function getMessageType()
    {
        return $this->messageType;
    }

    function setMessageType($var)
    {
        $this->messageType = $var;
    }
}