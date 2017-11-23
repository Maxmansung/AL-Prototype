<?php
interface shrine_Interface
{

    function getShrineID();
    function setShrineID($var);
    function getMapID();
    function setMapID($var);
    function getZoneID();
    function setZoneID($var);
    function getShrineType();
    function setShrineType($var);
    function getHistory();
    function setHistory($var);
    function addHistory($key,$var);
    function getCurrentArray();
    function setCurrentArray($var);
    function addCurrentArray($key,$var);
    function getShrineName();
    function setShrineName($var);
    function getDescription();
    function setDescription($var);
    function getShrineIcon();
    function setShrineIcon($var);
    function getWorshipCost();
    function setWorshipCost($var);
    function getWorshipDescription();
    function setWorshipDescription($var);
    function getMinParty();
    function setMinParty($var);
    function getMaxParty();
    function setMaxParty($var);
    function getShrineBonus();
    function setShrineBonus($var);
    function getShrineBonusType();
    function getShrineBonusReward();
    function getBlessingMessage();
    function setBlessingMessage($var);
}