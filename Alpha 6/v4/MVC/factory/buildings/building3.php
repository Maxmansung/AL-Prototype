<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building3 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 3;
        $this->name = "Camp";
        $this->icon = "outpostMarker";
        $this->description = "Claim the zone for your party and begin to protect your things";
        $this->itemsRequired = [4=>1];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 5;
        $this->fuelBuilding = 0;
        $this->buildingTypeID = 2;
        $this->tutorialKnown = 1;
        $this->mainKnown = 1;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array();
    }

    public function postBuildingDatabase(){
        buildingModel::insertBuilding($this,"Insert");
    }

    public function newBuildingFunctions($zone,$avatar)
    {
        $zone->updateZone();
        $avatar->updateAvatar();

    }

}