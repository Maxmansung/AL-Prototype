<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome1 extends biomeType
{

    function __construct()
    {
        $this->depth = 1;
        $this->value = "Frozen Soil";
        $this->description = "Bare soil, not even a patch of snow left covering";
        $this->descriptionLong = "This is a longer description of the soil";
        $this->temperatureMod = 1;
        $this->findingChanceMod = 1;
        $this->finalType = 1;
        $this->biomeImage = "dirt";
        $this->biomeItems = [6,6,20,10,11,11,11,7];
    }
}