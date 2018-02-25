<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface biomeType_Interface
{
    function getDepth();
    function setDepth($var);
    function getValue();
    function setValue($var);
    function getDescription();
    function setDescription($var);
    function getDescriptionLong();
    function setDescriptionLong($var);
    function getTemperatureMod();
    function setTemperaturemod($var);
    function getFindingChanceMod();
    function setFindingChangeMod($var);
    function getFinalType();
    function setFinalType($var);
    function getBiomeImage();
    function setBiomeImage($var);
}