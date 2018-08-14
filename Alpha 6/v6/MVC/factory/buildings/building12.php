<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building12 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 12;
        $this->name = "Seedlings";
        $this->icon = "seedlings";
        $this->description = "Maybe if you plant some seeds and hope really hard you can reverse the damage you've done...";
        $this->itemsRequired = [15=>2,34=>2];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 12;
        $this->fuelBuilding = 0;
        $this->buildingTypeID = 3;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array();
        $this->badBiomes = [4,6,100];
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
            if (!in_array($zone->getBiomeType(),$this->badBiomes)){
                if ($zone->getBiomeType() === 3){
                    $zone->setBiomeType(4);
                } elseif ($zone->getBiomeType() === 5) {
                    $zone->setBiomeType(8);
                } else {
                    $zone->setBiomeType(3);
                }
            }
            $zone->removeBuilding($this->getBuildingTemplateID());
            $zone->resetFindingChances();
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
        return "With some fertilizer, beans and a lot of hope you might be able to get a few things to sprout and improve the region a little. Scrubland becomes Forests, Lakes fill with litchen and everything else might be able to grow a little scrub.";
    }

}