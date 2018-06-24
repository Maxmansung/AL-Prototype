<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment9 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 9;
        $this->equipName = "Fur Coat";
        $this->heatBonus = 10;
        $this->backpackBonus = 0;
        $this->cost1Item = 7;
        $this->cost1Count = 2;
        $this->cost2Item = 8;
        $this->cost2Count = 1;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}