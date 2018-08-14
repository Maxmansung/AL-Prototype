<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building17 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 17;
        $this->name = "Rotting Log";
        $this->icon = "log";
        $this->description = "This might look like a rotting log to you, but perhaps some food could grow on it";
        $this->itemsRequired = [1=>4,13=>4,20=>2,34=>1];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 16;
        $this->fuelBuilding =  0;
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
            $items = rand(1, 4);
            for ($x = 0; $x < $items; $x++) {
                $type = rand(0,3);
                if ($type === 0){
                    $zone->addItem(18);
                } else {
                    $zone->addItem(20);
                }
            }
            $zone->updateZone();
        }
        return true;
    }

    public function getTempBonus($zone)
    {
        return 0;
    }

    function getLongDescription(){
        return "Think of this as your own personal vegetable plot, except instead of vegetables it grows moss and mushrooms. Every night between 1 and 4 items will be produced with a 1/4 chance of getting a mushroom.";
    }

}