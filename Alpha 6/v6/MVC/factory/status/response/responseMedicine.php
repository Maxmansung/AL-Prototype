<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class responseMedicine extends responseController
{

    function __construct()
    {
        $this->changeType = "Medicine";
        $this->failStatus = 6;
        $this->succeedStatus = 3;
    }

    function statusChange($statusArray){
        $statusArray[6] = 1;
        $statusArray[3] = 0;
        return $statusArray;
    }
}