<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment25 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 25;
        $this->equipName = "Ice Trailer";
        $this->heatBonus = -7;
        $this->backpackBonus = 8;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}