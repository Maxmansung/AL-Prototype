<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/equipment_Interface.php");
class equipment implements equipment_Interface
{

    protected $equipmentID;
    protected $equipName;
    protected $heatBonus;
    protected $backpackBonus;
    protected $cost1Item;
    protected $cost1Count;
    protected $cost2Item;
    protected $cost2Count;
    protected $upgrade1;
    protected $upgrade2;
    protected $equipImage;

    function returnVars(){
        return get_object_vars($this);
    }

    function getEquipmentID()
    {
        return $this->equipmentID;
    }

    function setEquipmentID($var)
    {
        $this->equipmentID = $var;
    }

    function getEquipName()
    {
        return $this->equipName;
    }

    function setEquipName($var)
    {
        $this->equipName = $var;
    }

    function getHeatBonus()
    {
        return $this->heatBonus;
    }

    function setHeatBonus($var)
    {
        $this->heatBonus = $var;
    }

    function getBackpackBonus()
    {
        return $this->backpackBonus;
    }

    function setBackpackBonus($var)
    {
        $this->backpackBonus = $var;
    }

    function getCost1Item()
    {
        return $this->cost1Item;
    }

    function setCost1Item($var)
    {
        $this->cost1Item = $var;
    }

    function getCost1Count()
    {
        return $this->cost1Count;
    }

    function setCost1Count($var)
    {
        $this->cost1Count = $var;
    }

    function getCost2Item()
    {
        return $this->cost2Item;
    }

    function setCost2Item($var)
    {
        $this->cost2Item = $var;
    }

    function getCost2Count()
    {
        return $this->cost2Count;
    }

    function setCost2Count($var)
    {
        $this->cost2Count = $var;
    }

    function getUpgrade1()
    {
        return $this->upgrade1;
    }

    function setUpgrade1($var)
    {
        $this->upgrade1 = $var;
    }

    function getUpgrade2()
    {
        return $this->upgrade2;
    }

    function setUpgrade2($var)
    {
        $this->upgrade2 = $var;
    }

    function getEquipImage()
    {
        return $this->equipImage;
    }

    function setEquipImage($var)
    {
        $this->equipImage = $var;
    }
}