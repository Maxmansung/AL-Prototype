<?php
interface chatlog_Interface
{

    function getChatlogID();
    function setChatlogID($var);
    function getMapID();
    function setMapID($var);
    function getZoneID();
    function setZoneID($var);
    function getAvatarID();
    function setAvatarID($var);
    function getMapDay();
    function setMapDay($var);
    function getMessageTime();
    function setMessageTime($var);
    function getMessageText();
    function setMessageText($var);
    function getChatlogType();
    function setChatlogType($var);
    function getGroupID();
    function setGroupID($var);
    function getMessageTimestamp();
    function setMessageTimestamp($var);
    function createMessageTime();
    function getBuildingID();
    function setBuildingID($var);
    function getOtherVar();
    function setOtherVar($var);
}