<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment5 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 5;
        $this->equipName = "Warming Rags";
        $this->heatBonus = 4;
        $this->backpackBonus = 1;
        $this->cost1Item = 8;
        $this->cost1Count = 2;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 9;
        $this->upgrade2 = 10;
        $this->equipImage = "sleepingIcon1";
    }

}