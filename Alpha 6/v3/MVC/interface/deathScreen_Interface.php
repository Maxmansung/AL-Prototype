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
    function getDeathStatistics();
    function setDeathStatistics($var);
    function getDeathAchievements();
    function setDeathAchievements($var);
    function getGameType();
    function setGameType($var);
    function getShrineScore();
    function setShrineScore($var);
    function getDeathType();
    function setDeathType($var);
    function getPartyPlayersLeft();
    function setPartyPlayersLeft($var);
    function getDayDuration();
    function setDayDuration($var);
}