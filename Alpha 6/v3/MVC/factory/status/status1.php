<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class status1 extends statuses
{

    function __construct()
    {
        $this->statusID = 1;
        $this->statusName = "Hungry";
        $this->statusDescription = "If you don't eat today you'll be starving tomorrow";
        $this->statusImage = "hungry";
        $this->statusModifier = 0;
        $this->startingStat = 0;
    }
}