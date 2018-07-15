<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment15 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 15;
        $this->equipName = "CC Awareness";
        $this->heatBonus = 10;
        $this->backpackBonus = 2;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 21;
        $this->upgrade2 = 22;
        $this->equipImage = "sleepingIcon1";
    }

}