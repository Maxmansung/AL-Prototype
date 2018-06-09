<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class status2 extends statuses
{

    function __construct()
    {
        $this->statusID = 2;
        $this->statusName = "Starving";
        $this->statusDescription = "If you don't find something to eat tonight you'll die";
        $this->statusImage = "starving";
        $this->statusModifier = 0;
        $this->startingStat = 0;
    }
}