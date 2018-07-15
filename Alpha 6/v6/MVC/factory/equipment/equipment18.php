<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment18 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 18;
        $this->equipName = "Chiseled Backpack";
        $this->heatBonus = -5;
        $this->backpackBonus = 7;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 24;
        $this->upgrade2 = 25;
        $this->equipImage = "sleepingIcon1";
    }

}