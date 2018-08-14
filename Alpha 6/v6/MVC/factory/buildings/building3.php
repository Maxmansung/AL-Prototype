<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building3 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 3;
        $this->name = "Camp";
        $this->icon = "outpostMarker";
        $this->description = "Claim the zone for your party and begin to protect your things";
        $this->itemsRequired = [4=>1];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 5;
        $this->fuelBuilding = 0;
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
        $zone->setControllingParty($avatar->getPartyID());
        $zone->setZoneOutpostName(nameGeneratorController::getNameAsText("camp"));
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
        return "With a bit of effort you can claim this as your own land. This is the most important step to protecting the region and items within it from those you dislike. Some might call it selfish but others may find it to be smart move. Once the region has been claimed you'll be able to find it on your map easily and start on the defensive buildings.";
    }

}