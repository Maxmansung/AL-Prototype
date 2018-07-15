<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment9 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 9;
        $this->equipName = "Stitched Fur";
        $this->heatBonus = 9;
        $this->backpackBonus = 1;
        $this->cost1Item = 7;
        $this->cost1Count = 2;
        $this->cost2Item = 8;
        $this->cost2Count = 1;
        $this->upgrade1 = 14;
        $this->upgrade2 = 15;
        $this->equipImage = "sleepingIcon1";
    }

}