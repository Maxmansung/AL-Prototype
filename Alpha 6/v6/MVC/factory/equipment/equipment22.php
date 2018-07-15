<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment22 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 22;
        $this->equipName = "Brassiere FFF";
        $this->heatBonus = 8;
        $this->backpackBonus = 3;
        $this->cost1Item = 8;
        $this->cost1Count = 1;
        $this->cost2Item = null;
        $this->cost2Count = 0;
        $this->upgrade1 = 1;
        $this->upgrade2 = 1;
        $this->equipImage = "sleepingIcon1";
    }

}