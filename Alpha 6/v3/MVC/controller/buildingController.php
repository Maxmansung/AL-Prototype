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
            $this->fuelBuilding = $buildingModel->fuelBuilding;
            $this->fuelRemaning = $buildingModel->fuelRemaning;
            $this->staminaSpent = $buildingModel->staminaSpent;
            $this->name = $buildingModel->name;
            $this->icon = $buildingModel->icon;
            $this->description = $buildingModel->description;
            $this->itemsRequired = $buildingModel->itemsRequired;
            $this->buildingsRequired = $buildingModel->buildingsRequired;
            $this->staminaRequired = $buildingModel->staminaRequired;
            $this->buildingType = $buildingModel->buildingType;
            $this->tutorialKnown = $buildingModel->tutorialKnown;
            $this->mainKnown = $buildingModel->mainKnown;
            $this->buildingTypeID = $buildingModel->buildingTypeID;
            $this->setIsBuilt($this->checkBuilt());
        }
    }

    public function createNewBuilding($buildingTemplateID, $zoneID){
        $zone = new zoneController($zoneID);
        $buildingModel = buildingModel::newbuilding($buildingTemplateID);
        $this->buildingID = $buildingModel->buildingID;
        $this->zoneID = $zone->getZoneID();
        $this->mapID = $zone->getMapID();
        $this->buildingTemplateID = $buildingModel->buildingTemplateID;
        $this->fuelBuilding = $buildingModel->fuelBuilding;
        $this->fuelRemaning = $buildingModel->fuelRemaning;
        $this->staminaSpent = $buildingModel->staminaSpent;
        $this->name = $buildingModel->name;
        $this->icon = $buildingModel->icon;
        $this->description = $buildingModel->description;
        $this->itemsRequired = $buildingModel->itemsRequired;
        $this->buildingsRequired = $buildingModel->buildingsRequired;
        $this->staminaRequired = $buildingModel->staminaRequired;
        $this->canBeBuilt = $buildingModel->canBeBuilt;
        $this->isBuilt = $buildingModel->isBuilt;
        $this->buildingType = $buildingModel->buildingType;
        $this->tutorialKnown = $buildingModel->tutorialKnown;
        $this->mainKnown = $buildingModel->mainKnown;
        $this->buildingTypeID = $buildingModel->buildingTypeID;
    }

    public static function createBlankBuilding($buildingTemplateID){
        $buildingModel = buildingModel::newbuilding($buildingTemplateID);
        $object = new buildingController("");
        $object->buildingTemplateID = $buildingModel->buildingTemplateID;
        $object->fuelBuilding = $buildingModel->fuelBuilding;
        $object->name = $buildingModel->name;
        $object->icon = $buildingModel->icon;
        $object->description = $buildingModel->description;
        $object->itemsRequired = $buildingModel->itemsRequired;
        $object->buildingsRequired = $buildingModel->buildingsRequired;
        $object->staminaRequired = $buildingModel->staminaRequired;
        $object->buildingType = $buildingModel->buildingType;
        $object->tutorialKnown = $buildingModel->tutorialKnown;
        $object->mainKnown = $buildingModel->mainKnown;
        $object->buildingTypeID = $buildingModel->buildingTypeID;
        return $object;
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
        if ($this->buildingID == "X"){
            $this->insertBuilding();
        } else {
            $this->updateBuilding();
        }
    }

    public function deleteBuilding(){
        buildingModel::deleteBuilding($this->buildingID);
    }

    public static function getAllBuildingsOfType($typeID){
        return buildingModel::getAlLBuildingsType($typeID);
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
        $buildingID =  buildingModel::findBuildingInZone($templateID,$zoneID);
        if (array_key_exists("ERROR",$buildingID) === true){
            return $buildingID;
        } else {
            return new buildingController($buildingID->getBuildingID());
        }
    }

    public static function getBuildingsArray($zoneID){
        $buildingArray = buildingModel::buildingsList();
        $zoneBuildingArray = buildingModel::zoneBuildingsArray($zoneID);
        foreach ($buildingArray as $key=>$item) {
            if (array_key_exists($key,$zoneBuildingArray)){
                $buildTest = new buildingController($zoneBuildingArray[$key]);
                $buildingArray[$key] = $buildTest;
            }
        }
        return $buildingArray;
    }

    public static function getMapBuildings($mapID,$buildingName){
        $buildingTempID = self::returnBuildingID($buildingName);
        $buildingArray = buildingModel::getMapBuildingsType($mapID,$buildingTempID);
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

    public static function getAllBuildings(){
        return $buildingsList = buildingModel::buildingsList();
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

    public static function getStartingBuildings($type){
        return buildingModel::getTutorialBuildings($type);
    }

    //////////////////////THIS NEED TO BE CHANGED IF BUILDING ID'S CHANGE /////////////////////////


    public static function returnBuildingID($buildingName){
        switch ($buildingName) {
            case "Firepit":
                $buildingType = "B0001";
                break;
            case "Storage":
                $buildingType = "B0002";
                break;
            case "Outpost":
                $buildingType = "B0003";
                break;
            case "StorageLock":
                $buildingType = "B0004";
                break;
            case "GateLock":
                $buildingType = "B0005";
                break;
            case "Capture":
                $buildingType = "B0006";
                break;
            case "Trap":
                $buildingType = "B0007";
                break;
            case "Smoke":
                $buildingType = "B0008";
                break;
            case "GateReinforce":
                $buildingType = "B0009";
                break;
            case "ButcherTable":
                $buildingType = "B0010";
                break;
            case "HeatRock":
                $buildingType = "B0011";
                break;
            case "Seedling":
                $buildingType = "B0012";
                break;
            case "firepitCage":
                $buildingType = "B0013";
                break;
            default:
                $buildingType = "";
                break;
        }
        return $buildingType;
    }

    public static function checkIfLock($buildingType){
        switch ($buildingType) {
            case "B0004":
                $check = true;
                break;
            case "B0005":
                $check = true;
                break;
            default:
                $check = false;
                break;
        }
        return $check;

    }
}


