<?php
interface item_Interface
{
    function getItemID();
    function setItemID($var);
    function getMapID();
    function setMapID($var);
    function getItemTemplateID();
    function setItemTemplateID($var);
    function getIdentity();
    function setIdentity($var);
    function getIcon();
    function setIcon($var);
    function getDescription();
    function setDescription($var);
    function getItemType();
    function setItemType($var);
    function getFindingChances();
    function setFindingChances($var);
    function getFuelValue();
    function setFuelValue($var);
    function getMaxCharges();
    function setMaxCharges($var);
    function getCurrentCharges();
    function setCurrentCharges($var);
    function getItemStatus();
    function setItemStatus($var);
    function getUsable();
    function setUsable($var);
    function getSurvivalBonus();
    function setSurvivalBonus($var);
}