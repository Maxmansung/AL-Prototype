<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment3 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 3;
        $this->equipName = "Rags with Pockets";
        $this->heatBonus = 0;
        $this->backpackBonus = 1;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 1;
        $this->upgrade2 = 2;
        $this->equipImage = "sleepingIcon1";
    }

}