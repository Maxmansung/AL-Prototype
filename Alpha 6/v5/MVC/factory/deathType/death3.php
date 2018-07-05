<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class death3 extends deathCause
{

    function __construct()
    {
        $this->key = 3;
        $this->causeName = "Snowman";
        $this->description = "You've angered the snowmen that moderate the world, make sure you don't do it again";
        $this->image = "";
    }
}