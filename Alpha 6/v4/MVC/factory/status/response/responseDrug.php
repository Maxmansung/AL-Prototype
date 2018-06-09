<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class responseDrug extends responseController
{

    function __construct()
    {
        $this->changeType = "Drug";
        $this->failResponse = "Your head is already spinning enough, anything more and your going to throw up!";
        $this->succeedResponse = "For a minute nothing happens, then you feel a slight popping behind your eyeballs and the world around you starts to melt";
        $this->failStatus = 4;
        $this->succeedStatus = false;
    }

    function statusChange($statusArray){
        $statusArray[4] = 1;
        return $statusArray;
    }
}