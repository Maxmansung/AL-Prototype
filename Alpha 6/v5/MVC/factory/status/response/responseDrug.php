<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class responseDrug extends responseController
{

    function __construct()
    {
        $this->changeType = "Drug";
        $this->failStatus = 4;
        $this->succeedStatus = false;
    }

    function statusChange($statusArray){
        $statusArray[4] = 1;
        return $statusArray;
    }
}