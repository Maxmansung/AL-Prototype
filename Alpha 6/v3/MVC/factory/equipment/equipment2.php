<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment2 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 2;
        $this->equipName = "Better Rags";
        $this->heatBonus = 1;
        $this->backpackBonus = 0;
        $this->cost1Item = "I0020";
        $this->cost1Count = 2;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 1;
        $this->upgrade2 = 3;
        $this->equipImage = "sleepingIcon1";
    }

}