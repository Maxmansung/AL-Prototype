<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building2 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 2;
        $this->name = "Snow Chest";
        $this->icon = "storage";
        $this->description = "A small snow chest to keep your things hidden";
        $this->itemsRequired = [2=>1];
        $this->buildingsRequired = 3;
        $this->staminaRequired = 10;
        $this->fuelBuilding = 10;
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
        $storage = new storageController("", "");
        $storage->createStorage($zone->getZoneID(), "10");
        $zone->setStorage(1);
        $storage->insertStorage();
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