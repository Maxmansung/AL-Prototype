<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface building_Interface
{
    function getBuildingID();
    function setBuildingID($var);
    function getZoneID();
    function setZoneID($var);
    function getMapID();
    function setMapID($var);
    function getBuildingTemplateID();
    function setBuildingTemplateID($var);
    function getFuelBuilding();
    function setFuelBuilding($var);
    function getFuelRemaining();
    function setFuelRemaining($var);
    function getName();
    function setName($var);
    function getIcon();
    function setIcon($var);
    function getDescription();
    function setDescription($var);
    function getItemsRequired();
    function setItemsRequired($var);
    function getBuildingsRequired();
    function setBuildingRequired($var);
    function getStaminaRequired();
    function setStaminaRequired($var);
    function getStaminaSpent();
    function setStaminaSpent($var);
    function getBuildingType();
    function setBuildingType($var);
    function getTutorialKnown();
    function setTutorialKnown($var);
    function getMainKnown();
    function setMainKnown($var);
    function getBuildingTypeID();
    function setBuildingTypeID($var);
}