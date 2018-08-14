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
        $zone->addBuilding($this->getBuildingTemplateID());
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

    public function getTempBonus($zone)
    {
        return 0;
    }

    function getLongDescription(){
        return "This essential action will need to become part of your daily routine if you want to keep the fire alive. Each day this will need to be performed to keep the fire going and if it's missed the next day you'll wake to a missing heat source.";
    }

}