<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building16 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 16;
        $this->name = "Charcoal Burner";
        $this->icon = "burner";
        $this->description = "Turn those useless old sticks into something far more useful!";
        $this->itemsRequired = [11=>3];
        $this->buildingsRequired = 1;
        $this->staminaRequired = 25;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 1;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(9);
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
        return "Charcoal is needed for some of the more advanced buildings and for better heat, its costly though and requires a lot more wood. This will allow access to some more advanced buildings though.";
    }

}