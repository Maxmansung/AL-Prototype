<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building1 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 1;
        $this->name = "Firepit";
        $this->icon = "firepit";
        $this->description = "Your main source of heat, this will keep you toasty warm";
        $this->itemsRequired = [3=>1,1=>3];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 8;
        $this->fuelBuilding = 1;
        $this->buildingTypeID = 1;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(1);
        $this->badBiomes = [100];
    }

    public function postBuildingDatabase(){
        buildingModel::insertBuilding($this,"Insert");
    }

    public function newBuildingFunctions($zone,$avatar)
    {
        $building = new buildingController("");
        $building->setStaminaSpent($building->getStaminaRequired());
        $building->setFuelRemaining($building->getFuelBuilding());
        $building->postBuildingDatabase();
        $building->createNewBuilding(13,$zone->getZoneID());
        $zone->addBuilding(13);
        $zone->updateZone();
        $avatar->updateAvatar();
    }

    public function dayEndingActions($map)
    {
        $buildingList = buildingModel::findBuildingsInMap($this->buildingTemplateID,$map->getMapID());
        foreach ($buildingList as $buildingModel){
            $building = new buildingController($buildingModel);
            if ($building->getFuelRemaining() === 0){
                $zone = new zoneController($building->getZoneID());
                $zone->removeBuilding($building->getBuildingTemplateID());
                $zone->updateZone();
                $building->deleteBuilding();
            } else {
                $building->modifyFuelRemaining(-1);
                $building->postBuildingDatabase();
            }
        }
        return true;
    }

    public function getTempBonus($zone)
    {
        return 10;
    }

    function getLongDescription(){
        return "The firepit is your basic building to keep everything warm and running. It can be used to to make torches and to start getting the zone warmer. Be aware that the firepit requires constant maintenance though, if you forget to stoke it one day it will fail and you'll have to start all over again.";
    }

    function getHeatDescription()
    {
        $words = "+".$this->getTempBonus(false)."&#176C";
        return $words;
    }

}