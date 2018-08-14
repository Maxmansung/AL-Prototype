<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building15 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 15;
        $this->name = "Cooking Pot";
        $this->icon = "cookingPot";
        $this->description = "This can be used to improve your food, assuming you have some food...";
        $this->itemsRequired = [26=>4];
        $this->buildingsRequired = 1;
        $this->staminaRequired = 20;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 1;
        $this->isBuilt = false;
        $this->staminaSpent = 0;
        $this->setTypeVars();
        $this->givesRecipe = array(18,19);
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
        return "The cooking pot turns some of the more disgusting foods into something more healthy and filling. Its an investment of stamina but if managed properly will much improve the food for those with access to it.";
    }

}