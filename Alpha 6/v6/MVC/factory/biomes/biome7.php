<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome7 extends biomeType
{

    function __construct()
    {
        $this->depth = 7;
        $this->value = "Boneyard";
        $this->description = "Huge bones stick out of the ground around you, something big died here a long time ago";
        $this->descriptionLong = "Here is a longer description of the boneyerd";
        $this->temperatureMod = -3;
        $this->findingChanceMod = 1;
        $this->finalType = 0;
        $this->biomeImage = "bones";
        $this->biomeItems = [2,22,2,2,29,29,30,28,10,8,2,22];
        $this->depletedTo = 2;
        $this->visibleMap = false;
    }

    public function performZoneChanges($zone)
    {
        return $zone;
    }
}