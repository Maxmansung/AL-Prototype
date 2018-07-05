<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome6 extends biomeType
{

    function __construct()
    {
        $this->depth = 6;
        $this->value = "Ice Field";
        $this->description = "Its just a patch of thick ice";
        $this->descriptionLong = "It looks like this used to be a lake but its frozen over now. Maybe you could break through it though?";
        $this->temperatureMod = -5;
        $this->findingChanceMod = 1;
        $this->finalType = 0;
        $this->biomeImage = "ice";
        $this->biomeItems = [17,17,17,17,17,19];
        $this->depletedTo = 5;
    }
}