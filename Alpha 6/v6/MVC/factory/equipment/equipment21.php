<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment21 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 21;
        $this->equipName = "Fur Coat";
        $this->heatBonus = 17;
        $this->backpackBonus = 0;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}