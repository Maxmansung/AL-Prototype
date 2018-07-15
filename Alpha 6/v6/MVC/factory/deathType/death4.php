<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class death4 extends deathCause
{

    function __construct()
    {
        $this->key = 4;
        $this->causeName = "Burnt";
        $this->description = "You spent the night beside a lava flow... On the bright side you didn't freeze, but your charred remains will hopefully serve as a warning to others.";
        $this->image = "";
    }
}