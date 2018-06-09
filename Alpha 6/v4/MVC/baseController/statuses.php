<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/statuses_Interface.php");
class statuses implements statuses_Interface
{
    protected $statusID;
    protected $statusName;
    protected $statusDescription;
    protected $statusImage;
    protected $statusModifier;
    protected $startingStat;

    function __toString()
    {
        $output = $this->statusID;
        $output .= '/ '.$this->statusName;
        $output .= '/ '.$this->statusDescription;
        $output .= '/ '.$this->statusImage;
        $output .= '/ '.$this->statusModifier;
        $output .= '/ '.$this->startingStat;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function returnViewVars(){
        $this->statusModifier = null;
        $this->startingStat = null;
        return get_object_vars($this);
    }

    function getStatusID()
    {
        return $this->statusID;
    }

    function setStatusID($var)
    {
        $this->statusID = $var;
    }

    function getStatusName()
    {
        return $this->statusName;
    }

    function setStatusName($var)
    {
        $this->statusName = $var;
    }

    function getStatusDescription()
    {
        return $this->statusDescription;
    }

    function setStatusDescription($var)
    {
        $this->statusDescription = $var;
    }

    function getStatusImage()
    {
        return $this->statusImage;
    }

    function setStatusImage($var)
    {
        $this->statusImage = $var;
    }

    function getModifier()
    {
        return $this->statusModifier;
    }

    function setModifier($var)
    {
        $this->statusModifier = $var;
    }

    function getStartingStat()
    {
        return $this->startingStat;
    }

    function setStartingStat($var)
    {
        $this->startingStat = $var;
    }
}