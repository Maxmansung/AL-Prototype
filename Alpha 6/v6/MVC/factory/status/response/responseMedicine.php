<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class responseMedicine extends responseController
{

    function __construct()
    {
        $this->changeType = "Medicine";
        $this->failStatus = false;
        $this->succeedStatus = 3;
    }

    function statusChange($statusArray){
        $statusArray[5] = 1;
        return $statusArray;
    }
}