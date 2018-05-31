<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class responseSnack extends responseController
{

    function __construct()
    {
        $this->changeType = "Snack";
        $this->failResponse = "You're not hungry enough to eat something so disgusting looking any more";
        $this->succeedResponse = "It barely touches the sides and leaves you unsure if you're still hungry or not...";
        $this->failStatus = 5;
        $this->succeedStatus = false;
    }


    function statusChange($statusArray)
    {
        $chance = rand(0, 1);
        if ($chance === 0) {
            $statusArray[1] = 0;
            $statusArray[2] = 0;
            $statusArray[5] = 1;
        }
        return $statusArray;
    }
}