<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface item_Interface
{
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
    function getUsable();
    function setUsable($var);
    function getSurvivalBonus();
    function setSurvivalBonus($var);
}