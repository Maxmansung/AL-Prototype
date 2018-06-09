<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class status5 extends statuses
{

    function __construct()
    {
        $this->statusID = 1;
        $this->statusName = "Fed";
        $this->statusDescription = "Your belly might not be full but there's no way you're ready to risk something so disgusting again today";
        $this->statusImage = "fed";
        $this->statusModifier = 0;
        $this->startingStat = 0;
    }
}