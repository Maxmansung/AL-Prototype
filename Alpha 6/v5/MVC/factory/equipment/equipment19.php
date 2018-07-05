<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment19 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 19;
        $this->equipName = "Snowman Huddle";
        $this->heatBonus = 28;
        $this->backpackBonus = -3;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}