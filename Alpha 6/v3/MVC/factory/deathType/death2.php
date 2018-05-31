<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class death2 extends deathCause
{

    function __construct()
    {
        $this->key = 2;
        $this->causeName = "Starvation";
        $this->description = "Make sure you eat regularly to stay alive";
        $this->image = "";
    }
}