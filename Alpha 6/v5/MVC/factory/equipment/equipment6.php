<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment6 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 6;
        $this->equipName = "Extra Pockets";
        $this->heatBonus = 0;
        $this->backpackBonus = 2;
        $this->cost1Item = 12;
        $this->cost1Count = 3;
        $this->cost2Item = 6;
        $this->cost2Count = 1;
        $this->upgrade1 = 10;
        $this->upgrade2 = 11;
        $this->equipImage = "sleepingIcon1";
    }

}