<?php
class buildingModel extends building
{

        private function __construct($buildingModel)
    {
        if (isset($buildingModel['buildingID'])) {
            $this->buildingID = $buildingModel['buildingID'];
            $this->zoneID = $buildingModel['zoneID'];
            $this->buildingTemplateID = $buildingModel['buildingTemplateID'];
            $this->fuelBuilding = $buildingModel['fuelBuilding'];
            $this->fuelRemaning = $buildingModel['fuelRemaining'];
            $this->staminaSpent = $buildingModel['staminaSpent'];
            $this->name = $buildingModel['name'];
            $this->icon = $buildingModel['icon'];
            $this->description = $buildingModel['description'];
            $this->itemsRequired = get_object_vars(json_decode($buildingModel['itemsRequired']));
            $this->buildingsRequired = $buildingModel['buildingsRequired'];
            $this->staminaRequired = $buildingModel['staminaRequired'];
            $this->canBeBuilt = false;
            $this->isBuilt = $this->checkBuilt();
        } else {
            $this->buildingID = "X";
            $this->zoneID = "X";
            $this->buildingTemplateID = $buildingModel['buildingTemplateID'];
            $this->fuelBuilding = $buildingModel['fuelBuilding'];
            $this->fuelRemaning = 0;
            $this->staminaSpent = 0;
            $this->name = $buildingModel['name'];
            $this->icon = $buildingModel['icon'];
            $this->description = $buildingModel['description'];
            $this->itemsRequired = get_object_vars(json_decode($buildingModel['itemsRequired']));
            $this->buildingsRequired = $buildingModel['buildingsRequired'];
            $this->staminaRequired = $buildingModel['staminaRequired'];
            $this->canBeBuilt = false;
            $this->isBuilt = $this->checkBuilt();
        }
    }


    public static function insertBuilding($buildingController, $type){
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Building (zoneID,buildingTemplateID,fuelRemaining,staminaSpent) VALUES (:zoneID,:buildingTemplateID,:fuelRemaining,:staminaSpent)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Building SET zoneID= :zoneID, buildingTemplateID= :buildingTemplateID, fuelRemaining= :fuelRemaining,staminaSpent= :staminaSpent WHERE buildingID= :buildingID");
        }
        $req->bindParam(':zoneID', $buildingController->getZoneID());
        $req->bindParam(':buildingTemplateID', $buildingController->getBuildingTemplateID());
        $req->bindParam(':fuelRemaining', $buildingController->getFuelRemaining());
        $req->bindParam(':staminaSpent', $buildingController->getStaminaSpent());
        if ($type == "Update") {
            $req->bindParam(':buildingID', $buildingController->getBuildingID());
        }
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
        $req = $db->prepare('SELECT Building.buildingID, Building.zoneID, Building.buildingTemplateID, Building.fuelRemaining, Building.staminaSpent, BuildingTemplate.name, BuildingTemplate.icon, BuildingTemplate.description, BuildingTemplate.itemsRequired, BuildingTemplate.buildingsRequired, BuildingTemplate.staminaRequired, BuildingTemplate.fuelBuilding  FROM Building INNER JOIN BuildingTemplate ON Building.buildingTemplateID = BuildingTemplate.buildingTemplateID AND Building.buildingID = :buildingID');
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
        $req = $db->prepare('SELECT Building.buildingID, Building.zoneID, Building.buildingTemplateID, Building.fuelRemaining, Building.staminaSpent, BuildingTemplate.name, BuildingTemplate.icon, BuildingTemplate.description, BuildingTemplate.itemsRequired, BuildingTemplate.buildingsRequired, BuildingTemplate.staminaRequired, BuildingTemplate.fuelBuilding  FROM Building INNER JOIN BuildingTemplate ON Building.buildingTemplateID = BuildingTemplate.buildingTemplateID AND Building.zoneID = :zoneID');
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
        $req = $db->prepare('SELECT Building.buildingID, Building.zoneID, Building.buildingTemplateID, Building.fuelRemaining, Building.staminaSpent, BuildingTemplate.name, BuildingTemplate.icon, BuildingTemplate.description, BuildingTemplate.itemsRequired, BuildingTemplate.buildingsRequired, BuildingTemplate.staminaRequired, BuildingTemplate.fuelBuilding  FROM Building INNER JOIN BuildingTemplate ON Building.buildingTemplateID = BuildingTemplate.buildingTemplateID AND Building.buildingTemplateID = :templateID AND Building.zoneID = :zoneID LIMIT 1');
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
        $zoneID = "%".$mapID."%";
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Building WHERE buildingTemplateID = :templateID AND Building.zoneID LIKE :zoneID');
        $req->bindParam(':templateID', $buildingID);
        $req->bindParam(':zoneID', $zoneID);
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

}