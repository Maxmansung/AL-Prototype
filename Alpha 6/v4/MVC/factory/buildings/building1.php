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
        $this->staminaRequired = 5;
        $this->fuelBuilding = 5;
        $this->buildingTypeID = 1;
        $this->tutorialKnown = 1;
        $this->mainKnown = 1;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(1);
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