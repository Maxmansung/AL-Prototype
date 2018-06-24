<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment4 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 4;
        $this->equipName = "Stuffed Rags";
        $this->heatBonus = 11;
        $this->backpackBonus = -2;
        $this->cost1Item = 12;
        $this->cost1Count = 2;
        $this->cost2Item = 20;
        $this->cost2Count = 1;
        $this->upgrade1 = 8;
        $this->upgrade2 = 9;
        $this->equipImage = "sleepingIcon1";
    }

}