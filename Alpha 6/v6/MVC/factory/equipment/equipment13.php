<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment13 extends equipment
{

    function __construct()
    {
        $this->equipmentID = 13;
        $this->equipName = "Puffer(fish) Jacket";
        $this->heatBonus = 20;
        $this->backpackBonus = -2;
        $this->cost1Item = 10;
        $this->cost1Count = 3;
        $this->cost2Item = 17;
        $this->cost2Count = 2;
        $this->upgrade1 = 19;
        $this->upgrade2 = 20;
        $this->equipImage = "sleepingIcon1";
    }

}