<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building25 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 25;
        $this->name = "Furnace";
        $this->icon = "furnace";
        $this->description = "This burns to quickly to keep you warm overnight, but perhaps you could melt some things in it";
        $this->itemsRequired = [37=>6,11=>3,14=>4];
        $this->buildingsRequired = 24;
        $this->staminaRequired = 40;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 1;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(11,21);
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
        return 5;
    }

    function getLongDescription(){
        return "The furnace adds a little more heat to the region, but more importantly it opens up new recipes in order to produce glass and metal from the basic resources.";
    }

    function getHeatDescription()
    {
        $words = "+".$this->getTempBonus(false)."&#176C";
        return $words;
    }

}