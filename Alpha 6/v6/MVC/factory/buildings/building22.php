<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building22 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 22;
        $this->name = "Rend Earth";
        $this->icon = "caveSpell";
        $this->description = "This is a powerful enchantment that could cause all sorts of havoc to the land. You better know what your doing...";
        $this->itemsRequired = [35=>1,39=>2];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 40;
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
        $zone->resetFindingChances();
        $zone->setBiomeType(13);
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
        return "This is a hugely expensive spell but is capable of turning a zone into a cave. Make sure that you save this for a zone you dont care too much about as there's no going back once it's done.";
    }

}