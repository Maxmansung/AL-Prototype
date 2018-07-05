<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class death1 extends deathCause
{

    function __construct()
    {
        $this->key = 1;
        $this->causeName = "Frozen";
        $this->description = "You didn't have enough warmth to survive the night";
        $this->image = "";
    }
}