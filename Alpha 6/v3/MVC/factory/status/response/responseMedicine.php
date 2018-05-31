<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class responseMedicine extends responseController
{

    function __construct()
    {
        $this->changeType = "Medicine";
        $this->failResponse = "At this point that's likely to make you sicker than better";
        $this->succeedResponse = "Wow, you're not sure if anything's healed but at least it doesn't hurt any more";
        $this->failStatus = false;
        $this->succeedStatus = 3;
    }

    function statusChange($statusArray){
        $statusArray[5] = 1;
        return $statusArray;
    }
}