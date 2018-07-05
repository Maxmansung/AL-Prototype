<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class buildingModel extends building
{

        private function __construct($buildingModel)
    {
            $this->buildingID = $buildingModel['buildingID'];
            $this->buildingTemplateID = $buildingModel['buildingTemplateID'];
            $this->fuelRemaning = intval($buildingModel['fuelRemaining']);
            $this->staminaSpent = intval($buildingModel['staminaSpent']);
            $this->zoneID = intval($buildingModel['zoneID']);
            $this->mapID = intval($buildingModel['mapID']);
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
        $req = $db->prepare('SELECT * FROM Building WHERE buildingID = :buildingID');
        $req->execute(array('buildingID' => $buildingID));
        $buildingModel = $req->fetch();
        return new buildingModel($buildingModel);
    }

    public static function zoneBuildingsArray($zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Building WHERE zoneID= :zoneID');
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
        $req = $db->prepare('SELECT * FROM Building WHERE zoneID= :zoneID AND buildingTemplateID= :templateID LIMIT 1');
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

    public static function findBuildingsInMap($templateID, $mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Building WHERE mapID= :mapID AND buildingTemplateID= :templateID');
        $req->bindParam(':templateID', $templateID);
        $req->bindParam(':mapID', $mapID);
        $req->execute();
        $buildingModel = $req->fetchAll();
        $buildingArray = [];
        foreach ($buildingModel as $building){
            $tempID = $building["buildingID"];
            $buildingArray[$tempID] = new buildingModel($building);
        }
        return $buildingArray;
    }

}