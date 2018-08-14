<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class building14 extends building
{
    function __construct()
    {
        $this->buildingTemplateID = 14;
        $this->name = "Lean-To";
        $this->icon = "leanTo";
        $this->description = "This small cover will provide you some heat, but it's not great for sharing";
        $this->itemsRequired = [1=>3,8=>1];
        $this->buildingsRequired = 0;
        $this->staminaRequired = 20;
        $this->fuelBuilding =  0;
        $this->buildingTypeID = 1;
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
        $players = count($zone->getAvatars());
        return floor(12/$players);
    }

    function getLongDescription(){
        return "For the more independent survivalist this lean too will give you a good amount of warmth. However, if you have to share it with others you may find yourself losing out on some of that warmth.";
    }

    function getHeatDescription()
    {
        $words = "+12&#176C (&#247 by the players in the zone)";
        return $words;
    }

}