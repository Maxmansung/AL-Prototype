<?php
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
}