<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface statuses_Interface
{
    function getStatusID();
    function setStatusID($var);
    function getStatusName();
    function setStatusName($var);
    function getStatusDescription();
    function setStatusDescription($var);
    function getStatusImage();
    function setStatusImage($var);
    function getModifier();
    function setModifier($var);
    function getStartingStat();
    function setStartingStat($var);

}