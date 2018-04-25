<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/reporting_Interface.php");
class reporting implements reporting_Interface
{

    protected $reportID;
    protected $reporter;
    protected $reportType;
    protected $reportObject;
    protected $reportedPlayer;
    protected $resolved;
    protected $details;
    protected $timestampCreated;
    protected $timestampResolved;
    protected $resolvedBy;


    public function __toString()
    {
        $output = $this->reportID;
        $output .= '/ '.$this->reporter;
        $output .= '/ '.$this->reportType;
        $output .= '/ '.$this->reportObject;
        $output .= '/ '.$this->reportedPlayer;
        $output .= '/ '.$this->resolved;
        $output .= '/ '.$this->details;
        return $output;
    }

    function returnVars()
    {
        return get_object_vars($this);
    }


    function getReportID()
    {
        return $this->reportID;
    }

    function setReportID($var)
    {
        $this->reportID = $var;
    }

    function getReporter()
    {
        return $this->reporter;
    }

    function setReporter($var)
    {
        $this->reporter = $var;
    }

    function getReportType()
    {
        return $this->reportType;
    }

    function setReportType($var)
    {
        $this->reportType = $var;
    }

    function getReportObject()
    {
        return $this->reportObject;
    }

    function setReportObject($var)
    {
        $this->reportObject = $var;
    }

    function getReportedPlayer()
    {
        return $this->reportedPlayer;
    }

    function setReportedPlayer($var)
    {
        $this->reportedPlayer = $var;
    }

    function getResolved()
    {
        return $this->resolved;
    }

    function setResolved($var)
    {
        $this->resolved = $var;
    }

    function getDetails()
    {
        return $this->details;
    }

    function setDetails($var)
    {
        $this->details = $var;
    }

    function getTimestampCreated()
    {
        return $this->timestampCreated;
    }

    function setTimestampCreated($var)
    {
        $this->timestampCreated = $var;
    }

    function getTimestampResolved()
    {
        return $this->timestampResolved;
    }

    function setTimestampResolved($var)
    {
        $this->timestampResolved = $var;
    }

    function getResolvedBy()
    {
        return $this->resolvedBy;
    }

    function setResolvedBy($var)
    {
        $this->resolvedBy = $var;
    }
}