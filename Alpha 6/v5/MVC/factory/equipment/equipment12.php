<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment12 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 12;
        $this->equipName = "Proper Backpack";
        $this->heatBonus = 0;
        $this->backpackBonus = 4;
        $this->cost1Item = 10;
        $this->cost1Count = 3;
        $this->cost2Item = 17;
        $this->cost2Count = 2;
        $this->upgrade1 = 17;
        $this->upgrade2 = 18;
        $this->equipImage = "sleepingIcon1";
    }

}