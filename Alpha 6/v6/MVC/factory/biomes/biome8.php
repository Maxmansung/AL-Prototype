<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome8 extends biomeType
{

    function __construct()
    {
        $this->depth = 8;
        $this->value = "Lichen Lake";
        $this->description = "A lake filled with weeds";
        $this->descriptionLong = "The lake has begun to grow more moss and weeds. It looks pretty stagnent but maybe there's something you can use";
        $this->temperatureMod = 3;
        $this->findingChanceMod = 3;
        $this->finalType = 0;
        $this->biomeImage = "lichen";
        $this->biomeItems = [20,20,20,19];
        $this->depletedTo = 5;
        $this->visibleMap = false;
    }

    public function performZoneChanges($zone)
    {
        return $zone;
    }
}