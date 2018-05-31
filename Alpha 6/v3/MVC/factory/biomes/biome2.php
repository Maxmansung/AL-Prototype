<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome2 extends biomeType
{

    function __construct()
    {
        $this->depth = 2;
        $this->value = "Snow Field";
        $this->description = "A vast plain of snow, almost entirely flat and completely empty";
        $this->descriptionLong = "Longer description of the snow plains goes here";
        $this->temperatureMod = 0;
        $this->findingChanceMod = 1;
        $this->finalType = 0;
        $this->biomeImage = "snow";
    }
}