<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface party_Interface
{
    function getPartyID();
    function setPartyID($var);
    function getMapID();
    function setMapID($var);
    function getMembers();
    function setMembers($var);
    function addMember($var);
    function removeMember($var);
    function getPartyName();
    function setPartyName($var);
    function getPendingRequests();
    function setPendingRequests($var);
    function addPendingRequests($var);
    function removePendingRequests($var);
    function getPendingBans();
    function setPendingBans($var);
    function addPendingBans($var);
    function removePendingBans($var);
    function getPlayersKnown();
    function setPlayersKnown($var);
    function addPlayersKnown($var);
    function removePlayersKnown($var);
    function getZoneExploration();
    function setZoneExploration($var);
    function addOverallZoneExploration($var,$biome,$depleted);
    function removeZoneExploration($var);
    function getTempBonus();
    function setTempBonus($var);
    function increaseTempBonus($var);
}