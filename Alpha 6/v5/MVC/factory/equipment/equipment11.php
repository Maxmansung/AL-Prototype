<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment11 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 11;
        $this->equipName = "Cargo Shorts";
        $this->heatBonus = 2;
        $this->backpackBonus = 3;
        $this->cost1Item = 8;
        $this->cost1Count = 2;
        $this->cost2Item = 10;
        $this->cost2Count = 2;
        $this->upgrade1 = 16;
        $this->upgrade2 = 17;
        $this->equipImage = "sleepingIcon1";
    }

}