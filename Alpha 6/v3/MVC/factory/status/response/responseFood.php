<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class responseFood extends responseController
{

    function __construct()
    {
        $this->changeType = "Food";
        $this->failResponse = "You're not hungry enough to eat something so disgusting looking any more";
        $this->succeedResponse = "You gulp down the disgusting mess and then do everything you can to stop it coming back up again...";
        $this->failStatus = 5;
        $this->succeedStatus = false;
    }

    function statusChange($statusArray){
        $statusArray[1] = 0;
        $statusArray[2] = 0;
        $statusArray[5] = 1;
        return $statusArray;
    }
}