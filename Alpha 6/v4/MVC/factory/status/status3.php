<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class status3 extends statuses
{

    function __construct()
    {
        $this->statusID = 3;
        $this->statusName = "Frostbite";
        $this->statusDescription = "You failed to keep yourself warm enough and the frost got you overnight";
        $this->statusImage = "frostbite";
        $this->statusModifier = 1;
        $this->startingStat = 0;
    }
}