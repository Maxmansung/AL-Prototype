<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building11 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 11;
        $this->name = "Heat Rock";
        $this->icon = "rock";
        $this->description = "This rock will help maintain some of the heat from the firepit";
        $this->itemsRequired = [11=>1];
        $this->buildingsRequired = 1;
        $this->staminaRequired = 10;
        $this->fuelBuilding = 1;
        $this->buildingTypeID = 1;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array();
        $this->badBiomes = [100];
    }

    public function postBuildingDatabase(){
        buildingModel::insertBuilding($this,"Insert");
    }

    public function newBuildingFunctions($zone,$avatar)
    {
        $zone->updateZone();
        $avatar->updateAvatar();
    }

    public function dayEndingActions($map)
    {
        $buildingList = buildingModel::findBuildingsInMap($this->buildingTemplateID,$map->getMapID());
        foreach ($buildingList as $buildingModel) {
            $building = new buildingController($buildingModel);
            $zone = new zoneController($building->getZoneID());
            if (in_array(1,$zone->getBuildings())){
                $temp = $building->getFuelRemaining();
                $building->setFuelRemaining(($temp+1));
            } else {
                $building->setFuelRemaining(0);
            }
            $building->postBuildingDatabase();
        }
        return true;
    }

    public function getTempBonus($zone)
    {
        return $this->getFuelRemaining();
    }

    function getLongDescription(){
        return "This rock will gradually get hotter beside the fire. Every night that the fire remains alight next to it the temperature of the rock will increase by 1. If the fire ever goes out though the rock will cool back off to nothing again.";
    }

    function getHeatDescription()
    {
        $words = "+1&#176C (per night)";
        return $words;
    }

}