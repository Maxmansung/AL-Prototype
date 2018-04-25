<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/profileWarning_Interface.php");
class profileWarning implements profileWarning_Interface
{
    protected $warningID;
    protected $profileID;
    protected $warningType;
    protected $reason;
    protected $points;
    protected $active;
    protected $givenTimestamp;
    protected $profileGiven;

    function returnVars(){
        return get_object_vars($this);
    }


    function getWarningID()
    {
        return $this->warningID;
    }

    function setWarningID($var)
    {
       $this->warningID = $var;
    }

    function getProfileID()
    {
        return $this->profileID;
    }

    function setProfileID($var)
    {
        $this->profileID = $var;
    }

    function getWarningType()
    {
        return $this->warningType;
    }

    function setWarningType($var)
    {
        $this->warningType = $var;
    }

    function getReason()
    {
        return $this->reason;
    }

    function setReason($var)
    {
        $this->reason = $var;
    }

    function getPoints()
    {
        return $this->points;
    }

    function setPoints($var)
    {
        $this->points = $var;
    }

    function getGivenTimestamp()
    {
        return $this->givenTimestamp;
    }

    function setGivenTimestamp($var)
    {
        $this->givenTimestamp = $var;
    }

    function getProfileGiven()
    {
        return $this->profileGiven;
    }

    function setProfileGiven($var)
    {
        $this->profileGiven = $var;
    }

    function getActive()
    {
        return $this->active;
    }

    function setActive($var)
    {
        $this->active = $var;
    }
}