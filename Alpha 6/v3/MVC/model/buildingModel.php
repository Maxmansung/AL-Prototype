<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class buildingModel extends building
{

        private function __construct($buildingModel)
    {
        if (isset($buildingModel['buildingID'])) {
            $this->buildingID = $buildingModel['buildingID'];
            $this->zoneID = intval($buildingModel['zoneID']);
            $this->mapID = intval($buildingModel['mapID']);
            $this->buildingTemplateID = $buildingModel['buildingTemplateID'];
            $this->fuelBuilding = intval($buildingModel['fuelBuilding']);
            $this->fuelRemaning = intval($buildingModel['fuelRemaining']);
            $this->staminaSpent = intval($buildingModel['staminaSpent']);
            $this->name = $buildingModel['name'];
            $this->icon = $buildingModel['icon'];
            $this->description = $buildingModel['description'];
            if (is_object(json_decode($buildingModel['itemsRequired']))) {
                $this->itemsRequired = get_object_vars(json_decode($buildingModel['itemsRequired']));
            } else {
                $this->itemsRequired = array();
            }
            $this->buildingsRequired = $buildingModel['buildingsRequired'];
            $this->staminaRequired = intval($buildingModel['staminaRequired']);
            $this->canBeBuilt = false;
            $this->isBuilt = $this->checkBuilt();
            $this->buildingTypeID = intval($buildingModel['buildingType']);
            $tempVar = buildingModel::getBuildingTypeDetails($this->buildingTypeID);
            $this->buildingType = $tempVar['typeName'];
            $this->tutorialKnown = intval($buildingModel['tutorialKnown']);
            $this->mainKnown = intval($buildingModel['mainKnown']);
        } else {
            $this->buildingID = "X";
            $this->zoneID = "X";
            $this->mapID = "X";
            $this->buildingTemplateID = $buildingModel['buildingTemplateID'];
            $this->fuelBuilding = $buildingModel['fuelBuilding'];
            $this->fuelRemaning = 0;
            $this->staminaSpent = 0;
            $this->name = $buildingModel['name'];
            $this->icon = $buildingModel['icon'];
            $this->description = $buildingModel['description'];
            if (is_object(json_decode($buildingModel['itemsRequired']))) {
                $this->itemsRequired = get_object_vars(json_decode($buildingModel['itemsRequired']));
            } else {
                $this->itemsRequired = array();
            }
            $this->buildingsRequired = $buildingModel['buildingsRequired'];
            $this->staminaRequired = intval($buildingModel['staminaRequired']);
            $this->canBeBuilt = false;
            $this->isBuilt = $this->checkBuilt();
            $this->buildingTypeID = intval($buildingModel['buildingType']);
            $tempVar = buildingModel::getBuildingTypeDetails($this->buildingTypeID);
            $this->buildingType =$tempVar['typeName'];
            $this->tutorialKnown = intval($buildingModel['tutorialKnown']);
            $this->mainKnown = intval($buildingModel['mainKnown']);
        }
    }


    public static function insertBuilding($buildingController, $type){
        $db = db_conx::getInstance();
        $zoneID = intval($buildingController->getZoneID());
        $mapID = intval($buildingController->getMapID());
        $buildingTemplateID = $buildingController->getBuildingTemplateID();
        $fuelRemaining = intval($buildingController->getFuelRemaining());
        $staminaSpent = intval($buildingController->getStaminaSpent());
        $buildingID = $buildingController->getBuildingID();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Building (zoneID, mapID,buildingTemplateID,fuelRemaining,staminaSpent) VALUES (:zoneID, :mapID, :buildingTemplateID,:fuelRemaining,:staminaSpent)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Building SET zoneID= :zoneID, mapID= :mapID, buildingTemplateID= :buildingTemplateID, fuelRemaining= :fuelRemaining,staminaSpent= :staminaSpent WHERE buildingID= :buildingID");
            $req->bindParam(':buildingID', $buildingID);
        }
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':buildingTemplateID', $buildingTemplateID);
        $req->bindParam(':fuelRemaining', $fuelRemaining);
        $req->bindParam(':staminaSpent', $staminaSpent);
        $req->execute();
    }


    public static function deleteBuilding($buildingID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM Building WHERE buildingID= :buildingID LIMIT 1');
        $req->execute(array('buildingID' => $buildingID));
        $req->fetch();
        return "Success";
    }


    public static function getBuilding($buildingID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT Building.buildingID, Building.zoneID, Building.mapID, Building.buildingTemplateID, Building.fuelRemaining, Building.staminaSpent, BuildingTemplate.name, BuildingTemplate.icon, BuildingTemplate.description, BuildingTemplate.itemsRequired, BuildingTemplate.buildingsRequired, BuildingTemplate.staminaRequired, BuildingTemplate.fuelBuilding, BuildingTemplate.buildingType, BuildingTemplate.tutorialKnown, BuildingTemplate.mainKnown FROM Building INNER JOIN BuildingTemplate ON Building.buildingTemplateID = BuildingTemplate.buildingTemplateID AND Building.buildingID = :buildingID');
        $req->execute(array('buildingID' => $buildingID));
        $buildingModel = $req->fetch();
        return new buildingModel($buildingModel);
    }


    public static function newBuilding($templateID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT *  FROM BuildingTemplate WHERE buildingTemplateID = :template');
        $req->execute(array('template' => $templateID));
        $buildingModel = $req->fetch();
        return new buildingModel($buildingModel);
    }

    public static function buildingsList(){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM BuildingTemplate');
        $req->execute();
        $buildingModel = $req->fetchAll();
        $buildingArray = [];
        foreach ($buildingModel as $building){
            $tempID = $building["buildingTemplateID"];
            $buildingArray[$tempID] = new buildingModel($building);
        }
        return $buildingArray;
    }

    public static function zoneBuildingsArray($zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT Building.buildingID, Building.zoneID, Building.mapID, Building.buildingTemplateID, Building.fuelRemaining, Building.staminaSpent, BuildingTemplate.name, BuildingTemplate.icon, BuildingTemplate.description, BuildingTemplate.itemsRequired, BuildingTemplate.buildingsRequired, BuildingTemplate.staminaRequired, BuildingTemplate.fuelBuilding, BuildingTemplate.buildingType, BuildingTemplate.tutorialKnown, BuildingTemplate.mainKnown FROM Building INNER JOIN BuildingTemplate ON Building.buildingTemplateID = BuildingTemplate.buildingTemplateID AND Building.zoneID = :zoneID');
        $req->execute(array('zoneID' => $zoneID));
        $buildingModel = $req->fetchAll();
        $buildingArray = [];
        foreach ($buildingModel as $building){
            $tempID = $building["buildingTemplateID"];
            $buildingArray[$tempID] = new buildingModel($building);
        }
        return $buildingArray;
    }

    public static function findBuildingInZone($templateID, $zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT Building.buildingID, Building.zoneID, Building.mapID, Building.buildingTemplateID, Building.fuelRemaining, Building.staminaSpent, BuildingTemplate.name, BuildingTemplate.icon, BuildingTemplate.description, BuildingTemplate.itemsRequired, BuildingTemplate.buildingsRequired, BuildingTemplate.staminaRequired, BuildingTemplate.fuelBuilding, BuildingTemplate.buildingType, BuildingTemplate.tutorialKnown, BuildingTemplate.mainKnown FROM Building INNER JOIN BuildingTemplate ON Building.buildingTemplateID = BuildingTemplate.buildingTemplateID AND Building.buildingTemplateID = :templateID AND Building.zoneID = :zoneID LIMIT 1');
        $req->bindParam(':templateID', $templateID);
        $req->bindParam(':zoneID', $zoneID);
        $req->execute();
        $building = $req->fetch();
        if (isset($building["buildingID"])) {
            $buildingModel = new buildingModel($building);
            return $buildingModel;
        } else {
            return array("ERROR" => 7);
        }
    }

    public static function getMapBuildingsType($mapID,$buildingID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Building WHERE buildingTemplateID = :templateID AND mapID= :mapID');
        $req->bindParam(':templateID', $buildingID);
        $req->bindParam(':mapID', $mapID);
        $req->execute();
        $buildingModel = $req->fetchAll();
        $buildingArray = [];
        $counter = 0;
        foreach ($buildingModel as $building){
            $buildingArray[$counter] = new buildingModel($building);
            $counter++;
        }
        return $buildingArray;
    }

    public static function getBuildingTypeDetails($typeID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM buildingType WHERE value = :valueType LIMIT 1');
        $req->execute(array(':valueType' => $typeID));
        $value = $req->fetch();
        return $value;
    }

    public static function getAlLBuildingsType($typeID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT buildingTemplateID FROM BuildingTemplate WHERE buildingType= :buildingType');
        $req->execute(array(':buildingType' => $typeID));
        $value = $req->fetchAll();
        $finalArray = [];
        foreach ($value as $building){
            array_push($finalArray,$building[0]);
        }
        return $finalArray;
    }

    public static function getTutorialBuildings($type){
        $db = db_conx::getInstance();
        if ($type === 3){
            $req = $db->prepare('SELECT buildingTemplateID FROM BuildingTemplate WHERE tutorialKnown = 1');
        } else{
            $req = $db->prepare('SELECT buildingTemplateID FROM BuildingTemplate WHERE mainKnown = 1');
        }
        $req->execute();
        $value = $req->fetchAll();
        $buildingArray = [];
        foreach ($value as $building){
            array_push($buildingArray,$building[0]);
        }
        return $buildingArray;
    }

}