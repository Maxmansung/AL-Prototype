<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building11 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 11;
        $this->name = "Heat Rock";
        $this->icon = "rock";
        $this->description = "This rock will help maintain some of the heat from the firepit";
        $this->itemsRequired = [11=>1];
        $this->buildingsRequired = 1;
        $this->staminaRequired = 10;
        $this->fuelBuilding = 1;
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

    public function getTempBonus()
    {
        return 0;
    }

}