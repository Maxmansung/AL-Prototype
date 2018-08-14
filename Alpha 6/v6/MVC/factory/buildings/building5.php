<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building5 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 5;
        $this->name = "Fence";
        $this->icon = "fence2";
        $this->description = "This will prevent anyone outside the party touching your stuff";
        $this->itemsRequired = [2=>5,21=>3];
        $this->buildingsRequired = 3;
        $this->staminaRequired = 30;
        $this->fuelBuilding = 20;
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
        $zone->setLockBuilt(1);
        $zone->setLockStrength(20);
        $zone->setLockMax(20);
        $zone->updateZone();
        $avatar->updateAvatar();
    }

    public function dayEndingActions($map)
    {
        return true;
    }

    public function getTempBonus($zone)
    {
        return 0;
    }

    function getLongDescription(){
        return "This is the big time defenses, you'll need the locks from a few other people to get this built but once you have no one will be able to access anything in the region. This includes using the buildings in the region, gaining heat from the buildings around and accessing the items in the chest. However, the region around can still be searched and items on the floor are outside of the gates.";
    }

}