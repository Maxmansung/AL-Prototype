<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface deathScreen_Interface
{

    function getProfileID();
    function setProfileID($var);
    function getMapID();
    function setMapID($var);
    function getPartyName();
    function setPartyName($var);
    function getDeathDay();
    function setDeathDay($var);
    function getNightTemp();
    function setNightTemp($var);
    function getSurvivableTemp();
    function setSurvivableTemp($var);
    function getDeathAchievements();
    function setDeathAchievements($var);
    function getGameType();
    function setGameType($var);
    function getDeathType();
    function setDeathType($var);
    function getDayDuration();
    function setDayDuration($var);
    function getFavourSolo();
    function setFavourSolo($var);
    function getFavourTeam();
    function setFavourTeam($var);
    function getFavourMap();
    function setFavourMap($var);
}