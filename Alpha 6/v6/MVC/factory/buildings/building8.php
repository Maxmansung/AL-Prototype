<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building8 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 8;
        $this->name = "Smoke Signals";
        $this->icon = "smokeSignal";
        $this->description = "This will let everyone know where your camp is, if this is a good or bad thing depends on your aim";
        $this->itemsRequired = [9=>2];
        $this->buildingsRequired = 1;
        $this->staminaRequired = 5;
        $this->fuelBuilding = 3;
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
        return true;
    }

    public function getTempBonus($zone)
    {
        return 0;
    }

    function getLongDescription(){
        return "Its a bit of waste of food but this building should make the fire obvious to every other player on the map. However, attracting everyone's attention may not always be a good thing so make sure it's something you really want to be doing.";
    }

}