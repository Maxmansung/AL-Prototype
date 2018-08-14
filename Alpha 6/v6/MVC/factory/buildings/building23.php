<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building23 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 23;
        $this->name = "Gods Wonder";
        $this->icon = "wonder";
        $this->description = "You could always spend your efforts building a great structure to the gods, but I wouldn't hope for much from it";
        $this->itemsRequired = [35=>2,37=>10];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 200;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 5;
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
        return "This building does nothing except waste stamina, resources and make the gods laugh. Eventually there could be a special achievement for this building.";
    }

}