<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class biome12 extends biomeType
{

    function __construct()
    {
        $this->depth = 12;
        $this->value = "Hot Springs";
        $this->description = "A bubbling fountain of hot water has appeared within this part of the lake!";
        $this->descriptionLong = "Boiling water flows up from the ground below, the smell seems to have killed everything in the water but the heat feels amazing against your face";
        $this->temperatureMod = 20;
        $this->findingChanceMod = -1;
        $this->finalType = 0;
        $this->biomeImage = "springs";
        $this->biomeItems = [5];
        $this->depletedTo = 9;
        $this->visibleMap = false;
    }

    public function performZoneChanges($zone)
    {
        $times = rand(2,4);
        for ($x=0;$x<$times;$x++){
            $zone->reduceFindingChances();
            $id = $this->findItem();
            $zone->addItem($id);
        }
        return $zone;
    }
}