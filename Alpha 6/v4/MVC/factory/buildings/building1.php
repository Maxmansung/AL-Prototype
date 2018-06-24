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
        $building->createNewBuilding(13,$zone->getZoneID());
        $building->setStaminaSpent($building->getStaminaRequired());
        $building->postBuildingDatabase();
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

    public function getTempBonus()
    {
        return 10;
    }

}