<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/profileAlert_Interface.php");
class profileAlert implements profileAlert_Interface
{

    protected $alertID;
    protected $profileID;
    protected $alertMessage;
    protected $title;
    protected $visible;
    protected $alerting;
    protected $dataID;
    protected $dataType;

    function returnVars(){
        return get_object_vars($this);
    }

    function getAlertID()
    {
        return $this->alertID;
    }

    function setAlertID($var)
    {
        $this->alertID = $var;
    }

    function getProfileID()
    {
        return $this->profileID;
    }

    function setProfileID($var)
    {
        $this->profileID = $var;
    }

    function getAlertMessage()
    {
        return $this->alertMessage;
    }

    function setAlertMessage($var)
    {
        $this->alertMessage = $var;
    }

    function getTitle()
    {
        return $this->title;
    }

    function setTitle($var)
    {
        $this->title = $var;
    }

    function getVisible()
    {
        return $this->visible;
    }

    function setVisible($var)
    {
        $this->visible = $var;
    }

    function getAlerting()
    {
        return $this->alerting;
    }

    function setAlerting($var)
    {
        $this->alerting = $var;
    }

    function getDataID()
    {
        return $this->dataID;
    }

    function setDataID($var)
    {
        $this->dataID = $var;
    }

    function getDataType()
    {
        return $this->dataType;
    }

    function setDataType($var)
    {
        $this->dataType = $var;
    }
}