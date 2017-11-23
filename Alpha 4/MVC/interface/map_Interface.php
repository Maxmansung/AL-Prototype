<?php
interface map_interface
{
    function getMapID();
    function setMapID($var);
    function getName();
    function setName($var);
    function getMaxPlayerCount();
    function setMaxPlayerCount($var);
    function getEdgeSize();
    function setEdgeSize($var);
    function getMaxPlayerStamina();
    function setMaxPlayerStamina($var);
    function getMaxPlayerInventorySlots();
    function setMaxPlayerInventorySlots($var);
    function getAvatars();
    function setAvatars($var);
    function addAvatar($var);
    function removeAvatar($var);
    function getCurrentDay();
    function setCurrentDay($var);
    function getDayDuration();
    function setDayDuration($var);
    function getBaseNightTemperature();
    function setBaseNightTemperature($var);
    function getBaseSurvivableTemperature();
    function setBaseSurvivableTemperature($var);
    function getBaseAvatarTemperatureModifier();
    function setBaseAvatarTemperatureModifier($var);
    function getDayEndTime();
    function setDayEndTime($var);
    function getTemperatureRecord();
    function setTemperatureRecord($var);
    function addTemperatureRecord($day,$var);
    function getSingleTemperatureRecord($day);
    function getGameType();
    function setGameType($var);
}