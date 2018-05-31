<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class equipment1 extends equipment
{

    function __construct()
    {
            $this->equipmentID = 1;
            $this->equipName = "Rags";
            $this->heatBonus = 0;
            $this->backpackBonus = 0;
            $this->cost1Item = "I0001";
            $this->cost1Count = 0;
            $this->cost2Item = null;
            $this->cost2Count = 0;
            $this->upgrade1 = 2;
            $this->upgrade2 = 3;
            $this->equipImage = "sleepingIcon1";
    }

}