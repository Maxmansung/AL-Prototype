<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building9 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 9;
        $this->name = "Fence Reinforcements";
        $this->icon = "fenceStone";
        $this->description = "This will make the region much more difficult to break into";
        $this->itemsRequired = [11=>10];
        $this->buildingsRequired = 5;
        $this->staminaRequired = 30;
        $this->fuelBuilding = 20;
        $this->buildingTypeID = 2;
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
        $zone->decreaseLockStrength(-10);
        $zone->decreaseLockMax(-10);
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
        return "This upgrade will improve the defense of your fences, adding another 10 stamina to its health. A worthwhile building if you really don't trust those other people around you but some may find it to be a waste of stamina.";
    }

}