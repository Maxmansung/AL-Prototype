<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building6 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 6;
        $this->name = "Capture Outpost";
        $this->icon = "outpostStolen";
        $this->description = "Its expensive but with a bit of work you could take over this camp";
        $this->itemsRequired = [];
        $this->buildingsRequired = 3;
        $this->staminaRequired = 10;
        $this->fuelBuilding = 0;
        $this->buildingTypeID = 2;
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
        $zone->setControllingParty($avatar->getPartyID());
        $zone->updateZone();
        $avatar->updateAvatar();
    }

    public function dayEndingActions($map)
    {
        $buildingList = buildingModel::findBuildingsInMap($this->buildingTemplateID,$map->getMapID());
        foreach ($buildingList as $buildingModel) {
            $building = new buildingController($buildingModel);
            $zone = new zoneController($building->getZoneID());
            $zone->removeBuilding($this->buildingTemplateID);
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