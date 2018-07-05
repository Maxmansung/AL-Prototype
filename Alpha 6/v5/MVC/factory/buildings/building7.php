<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building7 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 7;
        $this->name = "Small Trap";
        $this->icon = "trap";
        $this->description = "With a little effort and a lot of luck you might catch an animal each night";
        $this->itemsRequired = [10=>3,12=>2,6=>1];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 10;
        $this->fuelBuilding = 0;
        $this->buildingTypeID = 3;
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
            $chance = rand(0,$zone->getCounter());
            if ($chance < 2){
                $zone->addItem(7);
            }
            $zone->setCounter(0);
            $zone->updateZone();
        }
        return true;
    }

    public function getTempBonus()
    {
        return 0;
    }

}