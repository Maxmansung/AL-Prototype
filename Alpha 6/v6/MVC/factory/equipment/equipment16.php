<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment16 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 16;
        $this->equipName = "All Rounder";
        $this->heatBonus = 3;
        $this->backpackBonus = 4;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 22;
        $this->upgrade2 = 23;
        $this->equipImage = "sleepingIcon1";
    }

}