<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface modTracking_Interface
{
    function getTrackID();
    function setTrackID($var);
    function getActionType();
    function setActionType($var);
    function getPerformedBy();
    function setPerformedBy($var);
    function getTimestampAction();
    function setTimestampAction($var);
    function getDetails1();
    function setDetails1($var);
    function getDetails2();
    function setDetails2($var);
}