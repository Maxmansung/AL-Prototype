<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building18 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 18;
        $this->name = "Workshop";
        $this->icon = "workshop";
        $this->description = "To the untrained eye this just looks like a flat surface in the snow, but from here you can create anything!";
        $this->itemsRequired = [17=>2,2=>4];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 10;
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
        return "On its own this building does nothing, but it open up much more options for construction once completed. Essential for those who are interested in creating much more advanced buildings and items.";
    }

}