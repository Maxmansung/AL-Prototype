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
            $this->tutorialKnown = $class->tutorialKnown;
            $this->mainKnown = $class->mainKnown;
            $this->buildingTypeID = $class->buildingTypeID;
            $this->buildingType = $class->buildingType;
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
        $this->tutorialKnown = $class->tutorialKnown;
        $this->mainKnown = $class->mainKnown;
        $this->buildingTypeID = $class->buildingTypeID;
        $this->buildingType = $class->buildingType;
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
        $buildingArray = self::getAllBuildings();
        for($x = 1; $x<=building::$totalBuildings;$x++) {
            if (array_key_exists($x, $zoneBuildingArray)) {
                $buildTest = new buildingController($zoneBuildingArray[$x]);
                $buildingArray[$x] = $buildTest;
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

    public static function getAllBuildings(){
        $buildingArray = [];
        for($x = 1; $x<=building::$totalBuildings;$x++) {
            $builtTemp = "building" . $x;
            $class = new $builtTemp();
            $buildingArray[$x] = $class;
        }
        return $buildingArray;
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
        return array(1,2,3);
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


