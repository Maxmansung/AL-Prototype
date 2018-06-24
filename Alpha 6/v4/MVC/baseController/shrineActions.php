<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/shrineActions_Interface.php");
class shrineActions implements shrineActions_Interface
{

    protected $worshipID;
    protected $avatar;
    protected $profileName;
    protected $partyID;
    protected $partyName;
    protected $mapID;
    protected $currentDay;
    protected $shrineType;
    protected $worshipTime;

    function returnVars()
    {
        return get_object_vars($this);
    }

    function getWorshipID()
    {
        return $this->worshipID;
    }

    function setWorshipID($var)
    {
        $this->worshipID = $var;
    }

    function getAvatar()
    {
        return $this->avatar;
    }

    function setAvatar($var)
    {
        $this->avatar = $var;
    }

    function getProfileName()
    {
        return $this->profileName;
    }

    function setProfileName($var)
    {
        $this->profileName = $var;
    }

    function getPartyID()
    {
        return $this->partyID;
    }

    function setPartyID($var)
    {
        $this->partyID = $var;
    }

    function getPartyName()
    {
        return $this->partyName;
    }

    function setPartyName($var)
    {
        $this->partyName = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getCurrentDay()
    {
        return $this->currentDay;
    }

    function setCurrentDay($var)
    {
        $this->currentDay = $var;
    }

    function getShrineType()
    {
        return $this->shrineType;
    }

    function setShrineType($var)
    {
        $this->shrineType = $var;
    }

    function getWorshipTime()
    {
        return $this->worshipTime;
    }

    function setWorshipTime($var)
    {
        $this->worshipTime = $var;
    }
}