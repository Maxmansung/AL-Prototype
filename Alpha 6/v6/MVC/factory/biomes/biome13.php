<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome13 extends biomeType
{

    function __construct()
    {
        $this->depth = 13;
        $this->value = "Cave";
        $this->description = "It looks like the whole world has split here, leaving a rock ledge that you could hide under";
        $this->descriptionLong = "This rock formation might not look like much, but it's protection from the elements is the best thing you're going to find out in this wilderness";
        $this->temperatureMod = 15;
        $this->findingChanceMod = -2;
        $this->finalType = 1;
        $this->biomeImage = "cave";
        $this->biomeItems = [11,11,11,11,11,11,11,11,33];
        $this->depletedTo = 0;
        $this->visibleMap = false;
    }

    public function performZoneChanges($zone)
    {
        return $zone;
    }
}