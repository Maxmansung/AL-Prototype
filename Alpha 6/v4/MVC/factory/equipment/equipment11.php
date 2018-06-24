<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment11 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 11;
        $this->equipName = "Proper Backpack";
        $this->heatBonus = 0;
        $this->backpackBonus = 4;
        $this->cost1Item = 8;
        $this->cost1Count = 2;
        $this->cost2Item = 10;
        $this->cost2Count = 2;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}