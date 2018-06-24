<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment10 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 10;
        $this->equipName = "All Rounder";
        $this->heatBonus = 5;
        $this->backpackBonus = 2;
        $this->cost1Item = 8;
        $this->cost1Count = 2;
        $this->cost2Item = 12;
        $this->cost2Count = 2;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}