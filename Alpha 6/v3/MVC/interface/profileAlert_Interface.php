<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface profileAlert_Interface
{

    function getAlertID();
    function setAlertID($var);
    function getProfileID();
    function setProfileID($var);
    function getAlertMessage();
    function setAlertMessage($var);
    function getTitle();
    function setTitle($var);
    function getVisible();
    function setVisible($var);
    function getAlerting();
    function setAlerting($var);
    function getDataID();
    function setDataID($var);
    function getDataType();
    function setDataType($var);
}