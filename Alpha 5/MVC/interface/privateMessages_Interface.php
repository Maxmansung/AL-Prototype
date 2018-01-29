<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface privateMessages_Interface
{

    function getMessageID();
    function setMessageID($var);
    function getReceivingAvatar();
    function setReceivingAvatar($var);
    function getSendingAvatar();
    function setSendingAvatar($var);
    function getMessageTitle();
    function setMessageTitle($var);
    function getMessageText();
    function setMessageText($var);
    function getTimeStamp();
    function setTimeStamp($var);
}