<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment8 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 8;
        $this->equipName = "Stuffed Rags";
        $this->heatBonus = 14;
        $this->backpackBonus = 0;
        $this->cost1Item = 19;
        $this->cost1Count = 2;
        $this->cost2Item = 8;
        $this->cost2Count = 1;
        $this->upgrade1 = 13;
        $this->upgrade2 = 14;
        $this->equipImage = "sleepingIcon1";
    }

}