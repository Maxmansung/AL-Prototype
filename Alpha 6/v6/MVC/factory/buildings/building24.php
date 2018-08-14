<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building24 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 24;
        $this->name = "Improved firepit";
        $this->icon = "firepit2";
        $this->description = "This is a lot warmer, but you'll have to use charcoal instead of wood to keep it alight";
        $this->itemsRequired = [11=>4,14=>6];
        $this->buildingsRequired = 1;
        $this->staminaRequired = 20;
        $this->fuelBuilding =  0;
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
        return 10;
    }

    function getLongDescription(){
        return "The advanced firepit improves the old firepit, offering another 10 heat to the zone. Eventually I will make this building change how the 'Stoke Fire' building works, causing it to change to charcoal instead of sticks.";
    }

    function getHeatDescription()
    {
        $words = "+".$this->getTempBonus(false)."&#176C";
        return $words;
    }

}