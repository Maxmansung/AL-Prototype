<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment7 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 7;
        $this->equipName = "Chiseled Backpack";
        $this->heatBonus = -5;
        $this->backpackBonus = 4;
        $this->cost1Item = 17;
        $this->cost1Count = 1;
        $this->cost2Item = 11;
        $this->cost2Count = 2;
        $this->upgrade1 = 11;
        $this->upgrade2 = 12;
        $this->equipImage = "sleepingIcon1";
    }

}