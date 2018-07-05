<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building13 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 13;
        $this->name = "Stoke Fire";
        $this->icon = "fireCage";
        $this->description = "The fire must be stoked every day to ensure it remains alight";
        $this->itemsRequired = [1=>2];
        $this->buildingsRequired = 1;
        $this->staminaRequired = 5;
        $this->fuelBuilding = 0;
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
        $firepit = buildingModel::findBuildingInZone(1,$zone->getZoneID());
        $building = new buildingController($firepit);
        $building->modifyFuelRemaining(1);
        $building->postBuildingDatabase();
        $zone->updateZone();
        $avatar->updateAvatar();
    }

    public function dayEndingActions($map)
    {
        $buildingList = buildingModel::findBuildingsInMap($this->buildingTemplateID,$map->getMapID());
        foreach ($buildingList as $buildingModel) {
            $building = new buildingController($buildingModel);
            $zone = new zoneController($building->getZoneID());
            $zone->removeBuilding($this->getBuildingTemplateID());
            $zone->updateZone();
            $building->deleteBuilding();
        }
        return true;
    }

    public function getTempBonus()
    {
        return 0;
    }

}