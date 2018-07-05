<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment14 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 14;
        $this->equipName = "Fur Rags";
        $this->heatBonus = 15;
        $this->backpackBonus = 0;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 20;
        $this->upgrade2 = 21;
        $this->equipImage = "sleepingIcon1";
    }

}