<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class status6 extends statuses
{

    function __construct()
    {
        $this->statusID = 6;
        $this->statusName = "Healed";
        $this->statusDescription = "You no longer have frostbite, but the next time you get too cold will still be the end of you";
        $this->statusImage = "healed";
        $this->statusModifier = 0;
        $this->startingStat = 0;
    }
}