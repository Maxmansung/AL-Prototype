<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building2 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 2;
        $this->name = "Snow Chest";
        $this->icon = "storage";
        $this->description = "A small snow chest to keep your things hidden";
        $this->itemsRequired = [2=>1];
        $this->buildingsRequired = 3;
        $this->staminaRequired = 10;
        $this->fuelBuilding = 10;
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