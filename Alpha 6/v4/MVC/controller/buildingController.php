<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/building.php");
require_once(PROJECT_ROOT."/MVC/model/buildingModel.php");
class buildingController extends building
{
    public function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)){
                $buildingModel = $id;
            } else {
                $buildingModel = buildingModel::getBuilding($id);
            }
            $this->buildingID = $buildingModel->buildingID;
            $this->zoneID = $buildingModel->zoneID;
            $this->mapID = $buildingModel->mapID;
            $this->buildingTemplateID = $buildingModel->buildingTemplateID;
            $this->fuelRemaning = $buildingModel->fuelRemaning;
            $this->staminaSpent = $buildingModel->staminaSpent;
            $building = "building".$this->buildingTemplateID;
            $class = new $building();
            $this->fuelBuilding = $class->fuelBuilding;
            $this->name = $class->name;
            $this->icon = $class->icon;
            $this->description = $class->description;
            $this->itemsRequired = $class->itemsRequired;
            $this->buildingsRequired = $class->buildingsRequired;
            $this->staminaRequired = $class->staminaRequired;
            $this->buildingTypeID = $class->buildingTypeID;
            $this->buildingType = $class->buildingType;
            $this->badBiomes = $class->badBiomes;
            $this->setIsBuilt($this->checkBuilt());
        }
    }

    public function createNewBuilding($buildingTemplateID, $zoneID){
        $zone = new zoneController($zoneID);
        $this->buildingTemplateID = $buildingTemplateID;
        $this->buildingID = null;
        $this->zoneID = $zone->getZoneID();
        $this->mapID = $zone->getMapID();
        $this->fuelRemaning = 0;
        $this->staminaSpent = 0;
        $building = "building".$this->buildingTemplateID;
        $class = new $building();
        $this->fuelBuilding = $class->fuelBuilding;
        $this->name = $class->name;
        $this->icon = $class->icon;
        $this->description = $class->description;
        $this->itemsRequired = $class->itemsRequired;
        $this->buildingsRequired = $class->buildingsRequired;
        $this->staminaRequired = $class->staminaRequired;
        $this->buildingTypeID = $class->buildingTypeID;
        $this->buildingType = $class->buildingType;
        $this->badBiomes = $class->badBiomes;
        $this->setIsBuilt($this->checkBuilt());
    }

    //This adds a new building to the database
    private function insertBuilding(){
        buildingModel::insertBuilding($this,"Insert");
    }

    //This updates a building on the database
    private function updateBuilding(){
        buildingModel::insertBuilding($this,"Update");
    }

    public function postBuildingDatabase(){
        if ($this->buildingID == null){
            $this->insertBuilding();
        } else {
            $this->updateBuilding();
        }
    }

    public function deleteBuilding(){
        buildingModel::deleteBuilding($this->buildingID);
    }

    public static function getConstructedBuildingID($buildingName, $zoneID){
        $buildingType = self::returnBuildingID($buildingName);
        $buildingID =  buildingModel::findBuildingInZone($buildingType,$zoneID);
        if (array_key_exists("ERROR",$buildingID) === true){
            return $buildingID;
        } else {
            return new buildingController($buildingID->getBuildingID());
        }
    }

    public static function findBuildingInZone($templateID, $zoneID){
        $building =  buildingModel::findBuildingInZone($templateID,$zoneID);
        if (array_key_exists("ERROR",$building) === true){
            $name = "building".$templateID;
            return new $name();
        } else {
            return new buildingController($building);
        }
    }

    public static function getBuildingsArray($zoneID){
        $zoneBuildingArray = buildingModel::zoneBuildingsArray($zoneID);
        $buildingArray = factoryClassArray::createAllBuildings();
        foreach($buildingArray as $building) {
            if (array_key_exists($building->getBuildingTemplateID(), $zoneBuildingArray)) {
                $buildTest = new buildingController($zoneBuildingArray[$building->getBuildingTemplateID()]);
                $buildingArray[$building->getBuildingTemplateID()] = $buildTest;
            }
        }
        return $buildingArray;
    }

    public static function getMapBuildings($mapID,$buildingName){
        $buildingTempID = self::returnBuildingID($buildingName);
        $buildingArray = buildingModel::findBuildingsInMap($buildingTempID,$mapID);
        $array = [];
        $counter = 0;
        foreach ($buildingArray as $building){
            $array[$counter]= new buildingController($building->getBuildingID());
            $counter++;
        }
        return $array;
    }

    public static function getLockValue($zoneID){
        $lockObject = buildingController::getConstructedBuildingID("GateLock",$zoneID);
        if (array_key_exists("ERROR",$lockObject) === true) {
            return 0;
        }
        else {
            return $lockObject->getFuelRemaining();
        }
    }

    public static function lockTotal($lock){
        $storageID = buildingController::returnBuildingID("StorageLock");
        $gateID =  buildingController::returnBuildingID("GateLock");
        $total = intval($lock->getFuelBuilding());
        if ($lock->getBuildingTemplateID() == $gateID){
            $gateReinforce = buildingController::getConstructedBuildingID("GateReinforce",$lock->getZoneID());
            if (array_key_exists("ERROR",$gateReinforce) !== true) {
                $total += intval($gateReinforce->getFuelBuilding());
            }
        } elseif ($lock->getBuildingTemplateID() == $storageID){
            //THIS WILL BE USED FOR ANY BUILDINGS THAT UPGRADE THE STORAGE LOCK
        }
        return $total;
    }

    public static function getStartingBuildings(){
        return array(1,2,3,13);
    }

    //////////////////////THIS NEED TO BE CHANGED IF BUILDING ID'S CHANGE /////////////////////////


    public static function returnBuildingID($buildingName){
        switch ($buildingName) {
            case "Firepit":
                $buildingType = 1;
                break;
            case "Storage":
                $buildingType = 2;
                break;
            case "Outpost":
                $buildingType = 3;
                break;
            case "StorageLock":
                $buildingType = 4;
                break;
            case "GateLock":
                $buildingType = 5;
                break;
            case "Capture":
                $buildingType = 6;
                break;
            case "Trap":
                $buildingType = 7;
                break;
            case "Smoke":
                $buildingType = 8;
                break;
            case "GateReinforce":
                $buildingType = 9;
                break;
            case "ButcherTable":
                $buildingType = 10;
                break;
            case "HeatRock":
                $buildingType = 11;
                break;
            case "Seedling":
                $buildingType = 12;
                break;
            case "firepitCage":
                $buildingType = 13;
                break;
            default:
                $buildingType = "";
                break;
        }
        return $buildingType;
    }
}


