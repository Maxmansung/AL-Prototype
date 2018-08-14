<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building21 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 21;
        $this->name = "Advanced Distillery";
        $this->icon = "distillery2";
        $this->description = "Wow, with this you should be able to create some really impressive things!";
        $this->itemsRequired = [37=>2,32=>2];
        $this->buildingsRequired = 20;
        $this->staminaRequired = 30;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 4;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(15);
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
        return "Similar to the basic distillery but better, this offers a few more recipe options and allows players even higher technology options.";
    }

}