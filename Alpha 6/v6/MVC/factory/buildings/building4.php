<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building4 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 4;
        $this->name = "Chest Lock";
        $this->icon = "storage-lock";
        $this->description = "With this build people are going to have a lot of problems running off with your things";
        $this->itemsRequired = [21=>1];
        $this->buildingsRequired = 2;
        $this->staminaRequired = 5;
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
        $storage = new storageController("",$zone->getZoneID());
        $storage->setLockBuilt(1);
        $storage->setLockStrength(20);
        $storage->setLockMax(20);
        $storage->uploadStorage();
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
        return "A lock will mean that other players cant access your things without a lot of effort. It comes with a starting defense of 20 stamina but further buildings may be able to improve this. Once the lock has been destroyed, those outside of your party will be able to access the items inside again so make sure you keep an eye on it's health.";
    }

}