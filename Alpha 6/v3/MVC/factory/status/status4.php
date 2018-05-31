<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class status4 extends statuses
{

    function __construct()
    {
        $this->statusID = 4;
        $this->statusName = "Hallucinating";
        $this->statusDescription = "Something you ate didn't agree much, the world is spinning now";
        $this->statusImage = "hallucinating";
        $this->statusModifier = 1;
        $this->startingStat = 0;
    }
}