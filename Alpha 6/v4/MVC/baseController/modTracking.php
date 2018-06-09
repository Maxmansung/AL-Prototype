<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/modTracking_Interface.php");
class modTracking implements modTracking_Interface
{
    protected $trackID;
    protected $actionType;
    protected $performedBy;
    protected $timestampAction;
    protected $details1;
    protected $details2;

    function returnVars(){
        return get_object_vars($this);
    }

    function getTrackID()
    {
        return $this->trackID;
    }

    function setTrackID($var)
    {
        $this->trackID = $var;
    }

    function getActionType()
    {
        return $this->actionType;
    }

    function setActionType($var)
    {
        $this->actionType = $var;
    }

    function getPerformedBy()
    {
        return $this->performedBy;
    }

    function setPerformedBy($var)
    {
        $this->performedBy = $var;
    }

    function getTimestampAction()
    {
        return $this->timestampAction;
    }

    function setTimestampAction($var)
    {
        $this->timestampAction = $var;
    }

    function getDetails1()
    {
        return $this->details1;
    }

    function setDetails1($var)
    {
        $this->details1 = $var;
    }

    function getDetails2()
    {
        return $this->details2;
    }

    function setDetails2($var)
    {
        $this->details2 = $var;
    }
}