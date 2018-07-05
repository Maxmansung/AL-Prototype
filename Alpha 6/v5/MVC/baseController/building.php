<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/building_Interface.php");
class building implements building_Interface
{
    //This is a count of all the building template classes
    static $totalBuildings = 3;

    protected $buildingID;
    protected $zoneID;
    protected $mapID;
    protected $buildingTemplateID;
    protected $fuelBuilding;
    protected $fuelRemaning;
    protected $staminaSpent;
    protected $name;
    protected $icon;
    protected $description;
    protected $itemsRequired;
    protected $buildingsRequired;
    protected $staminaRequired;
    //This is used to detect if the building object can be built (if there are enough resources
    protected $canBeBuilt;
    //This is used to detect if the building is already built (stamina spent = to stamina required)
    protected $isBuilt;
    protected $buildingType;
    protected $buildingTypeID;
    protected $parentBuilt;
    protected $givesRecipe;
    protected $badBiomes;


    public function __toString()
    {
        $output = $this->buildingID;
        $output .= '/ '.$this->zoneID;
        $output .= '/ '.$this->buildingTemplateID;
        $output .= '/ '.$this->fuelBuilding;
        $output .= '/ '.$this->fuelRemaning;
        $output .= '/ '.$this->staminaSpent;
        $output .= '/ '.$this->name;
        $output .= '/ '.$this->icon;
        $output .= '/ '.$this->description;
        $output .= '/ '.json_encode($this->itemsRequired);
        $output .= '/ '.$this->buildingsRequired;
        $output .= '/ '.$this->staminaRequired;
        $output .= '/ '.$this->canBeBuilt;
        $output .= '/ '.$this->isBuilt;
        $output .= '/ '.$this->buildingType;
        $output .= '/ '.$this->buildingTypeID;
        return $output;
    }

    public function returnVars(){
        return get_object_vars($this);
    }


    function getBuildingID()
    {
        return $this->buildingID;
    }

    function setBuildingID($var)
    {
        $this->buildingID = $var;
    }

    function getZoneID()
    {
        return $this->zoneID;
    }

    function setZoneID($var)
    {
        $this->zoneID = $var;
    }

    function getBuildingTemplateID()
    {
        return $this->buildingTemplateID;
    }

    function setBuildingTemplateID($var)
    {
        $this->buildingTemplateID = $var;
    }

    function getFuelBuilding()
    {
        return $this->fuelBuilding;
    }

    function setFuelBuilding($var)
    {
        $this->fuelBuilding = $var;
    }

    function getFuelRemaining()
    {
        return $this->fuelRemaning;
    }

    function setFuelRemaining($var)
    {
        $int = intval($var);
        $this->fuelRemaning = $int;
    }

    function modifyFuelRemaining($var){
        $this->fuelRemaning += $var;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($var)
    {
        $this->name = $var;
    }

    function getIcon()
    {
        return $this->icon;
    }

    function setIcon($var)
    {
        $this->icon = $var;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getItemsRequired()
    {
        return $this->itemsRequired;
    }

    function setItemsRequired($var)
    {
        $this->itemsRequired = $var;
    }

    function getBuildingsRequired()
    {
        return $this->buildingsRequired;
    }

    function setBuildingRequired($var)
    {
        $this->buildingsRequired = $var;
    }

    function getStaminaRequired()
    {
        return $this->staminaRequired;
    }

    function setStaminaRequired($var)
    {
        $this->staminaRequired = $var;
    }

    function getStaminaSpent()
    {
        return $this->staminaSpent;
    }

    function setStaminaSpent($var)
    {
        $this->staminaSpent = $var;
    }

    function addStaminaSpent($var){
        $this->staminaSpent += $var;
    }

    function getCanBeBuilt()
    {
        return $this->canBeBuilt;
    }

    function SetCanBeBuilt($var)
    {
        $this->canBeBuilt = $var;
    }

    function getIsBuilt()
    {
        return $this->isBuilt;
    }

    function setIsBuilt($var)
    {
        $this->isBuilt = $var;
    }

    protected function checkBuilt(){
        if ($this->staminaSpent >= $this->staminaRequired){
            return true;
        } else {
            return false;
        }
    }

    function checkCanBeBuilt(){
        $this->canBeBuilt = true;
        if ($this->parentBuilt === true) {
            foreach ($this->itemsRequired as $item) {
                if ($item["materialNeeded"] > $item["materialOwned"]) {
                    $this->canBeBuilt = false;
                }
            }
        } else {
            $this->canBeBuilt = false;
        }
    }

    public function checkBuildingBuilt($templateID, $zoneID){
        return buildingModel::findBuildingInZone($templateID,$zoneID);
    }


    function getBuildingType()
    {
        return $this->buildingType;
    }

    function setBuildingType($var)
    {
        $this->buildingType = intval($var);
    }

    function getBuildingTypeID()
    {
        return $this->buildingTypeID;
    }

    function setBuildingTypeID($var)
    {
        $this->buildingTypeID = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getParentBuilt()
    {
        return $this->parentBuilt;
    }

    function setParentBuilt($var)
    {
        $this->parentBuilt = $var;
    }

    function setTypeVars()
    {
        $tempVar = "buildingType".$this->buildingTypeID;
        $class = new $tempVar();
        $this->buildingType = $class->getTypeName();
    }

    function getGivesRecipe()
    {
        return $this->givesRecipe;
    }

    function setGivesRecipe($var)
    {
        $this->givesRecipe = $var;
    }

    function getBadBiomes()
    {
        return $this->badBiomes;
    }

    function setBadBiomes($var)
    {
        $this->badBiomes = $var;
    }
}