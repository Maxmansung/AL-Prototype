<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building10 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 10;
        $this->name = "Butchery Table";
        $this->icon = "trap";
        $this->description = "With a little practice you can maybe get more precise with the butchery of those small animals";
        $this->itemsRequired = [6=>3,11=>2];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 10;
        $this->fuelBuilding = 0;
        $this->buildingTypeID = 3;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(5,6,7);
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

    public function getTempBonus()
    {
        return 0;
    }

}