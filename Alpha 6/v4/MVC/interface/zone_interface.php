<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface zone_interface
{
    function getZoneID();
    function setZoneID($var);
    function getName();
    function setName($var);
    function getMapID();
    function setMapID($var);
    function getCoordinateX();
    function setCoordinateX($var);
    function getCoordinateY();
    function setCoordinateY($var);
    function getAvatars();
    function setAvatars($var);
    function addAvatar($var);
    function removeAvatar($var);
    function getBuildings();
    function setBuildings($var);
    function addBuilding($var);
    function removeBuilding($var);
    function getControllingParty();
    function setControllingParty($var);
    function getProtectedType();
    function setProtectedType($var);
    function getStorage();
    function setStorage($var);
    function getFindingChances(); //This needs thinking about how it will work
    function setFindingChances($var); //This needs thinking about how it will work
    function getBiomeType();
    function setBiomeType($var);
    function getZoneOutpostName();
    function setZoneOutpostName($var);
    function getZoneSurvivableTemperatureModifier();
    function setZoneSurvivableTemperatureModifier($var);
    function getCounter();
    function setCounter($var);
    function adjustCounter($var);
    function getLockBuilt();
    function setLockBuilt($var);
    function getLockStrength();
    function setLockStrength($var);
    function getLockMax();
    function setLockMax($var);
    function getZoneItems();
    function setZoneItems($var);
}