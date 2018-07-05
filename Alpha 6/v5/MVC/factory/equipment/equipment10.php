<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment10 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 10;
        $this->equipName = "Bra";
        $this->heatBonus = 6;
        $this->backpackBonus = 2;
        $this->cost1Item = 8;
        $this->cost1Count = 2;
        $this->cost2Item = 12;
        $this->cost2Count = 2;
        $this->upgrade1 = 15;
        $this->upgrade2 = 16;
        $this->equipImage = "sleepingIcon1";
    }

}