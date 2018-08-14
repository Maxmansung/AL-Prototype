<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building20 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 20;
        $this->name = "Basic Distillery";
        $this->icon = "distillery";
        $this->description = "You might be able to use this to cook up some better items";
        $this->itemsRequired = [14=>3,27=>2,12=>3];
        $this->buildingsRequired = 18;
        $this->staminaRequired = 20;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 4;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(10,12,17,22);
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
        return "The distillery opens up a lot more recipe options, turning out better drugs, fertilizer and even cement. Its a big investment in resources and stamina but an essential if you want those improved buildings and items.";
    }

}