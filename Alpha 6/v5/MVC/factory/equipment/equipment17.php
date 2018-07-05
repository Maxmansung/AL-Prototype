<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment17 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 17;
        $this->equipName = "Cargo Pants";
        $this->heatBonus = 0;
        $this->backpackBonus = 5;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 23;
        $this->upgrade2 = 25;
        $this->equipImage = "sleepingIcon1";
    }

}