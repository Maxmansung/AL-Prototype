<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome100 extends biomeType
{

    function __construct()
    {
        $this->depth = 100;
        $this->value = "Shrine";
        $this->description = "The region is blank and empty except the small mound in the center";
        $this->descriptionLong = "A small shrine of snow and ice sits in the center of this zone, all around is empty and cold and the shrine itself seems to emminate an aura of chill. Perhaps you could gain some favour here...";
        $this->temperatureMod = -100;
        $this->findingChanceMod = 0;
        $this->finalType = 1;
        $this->biomeImage = "shrine";
    }
}