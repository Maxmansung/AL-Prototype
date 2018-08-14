<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome10 extends biomeType
{

    function __construct()
    {
        $this->depth = 10;
        $this->value = "Quarry";
        $this->description = "With so much digging in the area this place is just a hole in the ground.";
        $this->descriptionLong = "The quarry is just a mess of rock and dust around. Perhaps there is something good this deep down though...";
        $this->temperatureMod = 15;
        $this->findingChanceMod = -1;
        $this->finalType = 1;
        $this->biomeImage = "quarry";
        $this->biomeItems = [11,11,11,11,11,14,36,36,36,33,33];
        $this->depletedTo = 0;
        $this->visibleMap = false;
    }

    public function performZoneChanges($zone)
    {
        return $zone;
    }
}