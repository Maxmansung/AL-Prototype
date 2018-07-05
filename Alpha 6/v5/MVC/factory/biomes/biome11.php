<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome11 extends biomeType
{

    function __construct()
    {
        $this->depth = 11;
        $this->value = "Lava Flow";
        $this->description = "The heat of the zone makes it unbearable to stay in but maybe you can find something good";
        $this->descriptionLong = "Lava flows out of the ground around, covering the land and burning on contact. It seems that some interesting minerals are being formed and uncovered";
        $this->temperatureMod = 100;
        $this->findingChanceMod = 4;
        $this->finalType = 0;
        $this->biomeImage = "lava";
        $this->biomeItems = [5];
        $this->depletedTo = 9;
    }
}