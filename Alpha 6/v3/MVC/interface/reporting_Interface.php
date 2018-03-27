<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface reporting_Interface
{

    function getReportID();
    function setReportID($var);
    function getReporter();
    function setReporter($var);
    function getReportType();
    function setReportType($var);
    function getReportObject();
    function setReportObject($var);
    function getReportedPlayer();
    function setReportedPlayer($var);
    function getResolved();
    function setResolved($var);
    function getDetails();
    function setDetails($var);
    function getTimestampCreated();
    function setTimestampCreated($var);
    function getTimestampResolved();
    function setTimestampResolved($var);
}