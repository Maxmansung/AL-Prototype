<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment24 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 24;
        $this->equipName = "Camping Backpack";
        $this->heatBonus = -2;
        $this->backpackBonus = 7;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}