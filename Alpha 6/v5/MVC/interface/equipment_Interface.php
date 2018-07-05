<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
interface equipment_Interface
{

    function getEquipmentID();
    function setEquipmentID($var);
    function getEquipName();
    function setEquipName($var);
    function getHeatBonus();
    function setHeatBonus($var);
    function getBackpackBonus();
    function setBackpackBonus($var);
    function getCost1Item();
    function setCost1Item($var);
    function getCost1Count();
    function setCost1Count($var);
    function getCost2Item();
    function setCost2Item($var);
    function getCost2Count();
    function setCost2Count($var);
    function getUpgrade1();
    function setUpgrade1($var);
    function getUpgrade2();
    function setUpgrade2($var);
    function getEquipImage();
    function setEquipImage($var);
}