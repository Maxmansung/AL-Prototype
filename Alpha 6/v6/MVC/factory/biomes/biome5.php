<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome5 extends biomeType
{

    function __construct()
    {
        $this->depth = 5;
        $this->value = "Lake";
        $this->description = "Looks like theres a gap in the snow and ice, you can see flowing water";
        $this->descriptionLong = "Somehow this water has managed not to freeze despite the temperature. Looking at the cracks in the ice surrounding it seems someone might have been here recently";
        $this->temperatureMod = -3;
        $this->findingChanceMod = 4;
        $this->finalType = 1;
        $this->biomeImage = "lake";
        $this->biomeItems = [19,20,20,17,17,13,13,13];
        $this->depletedTo = 0;
        $this->visibleMap = false;
    }

    public function performZoneChanges($zone)
    {
        return $zone;
    }
}