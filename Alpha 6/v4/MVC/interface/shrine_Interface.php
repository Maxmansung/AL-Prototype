<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface shrine_Interface
{

    function getShrineID();
    function setShrineID($var);
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