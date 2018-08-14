<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building19 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 19;
        $this->name = "Carve Bowl";
        $this->icon = "bowl";
        $this->description = "It's not amazing but maybe you could use this to hold something?";
        $this->itemsRequired = [11=>1];
        $this->buildingsRequired = 18;
        $this->staminaRequired = 15;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 4;
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
        $zone->removeBuilding($this->getBuildingTemplateID());
        $zone->addItem(27);
        $zone->updateZone();
        $avatar->updateAvatar();
        $building = buildingController::findBuildingInZone($this->getBuildingTemplateID(), $avatar->getZoneID());
        $building->deleteBuilding();
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
        return "This is more of a recipe than a building, but it takes time and effort to carve a bowl from a stone and so the stamina investment requires it to be a building. This can be built as many times as you want, with the resulting item appearing on the floor once completed.";
    }

}