<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface profileWarning_Interface
{

    function getWarningID();
    function setWarningID($var);
    function getProfileID();
    function setProfileID($var);
    function getWarningType();
    function setWarningType($var);
    function getReason();
    function setReason($var);
    function getPoints();
    function setPoints($var);
    function getActive();
    function setActive($var);
    function getGivenTimestamp();
    function setGivenTimestamp($var);
    function getProfileGiven();
    function setProfileGiven($var);
}