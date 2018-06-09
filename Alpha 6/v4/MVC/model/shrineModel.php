<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class shrineModel extends shrine
{
    private function __construct($shrineModel)
    {
        $this->shrineID = intval($shrineModel['shrineID']);
        $this->mapID = intval($shrineModel['mapID']);
        $this->zoneID = intval($shrineModel['zoneID']);
        $this->shrineType = intval($shrineModel['shrineType']);
    }

    public static function getShrineByID($shrineID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrines WHERE shrineID= :shrineID LIMIT 1');
        $req->execute(array('shrineID' => $shrineID));
        $shrineModel = $req->fetch();
        return new shrineModel($shrineModel);
    }

    public static function findShrineInZone($zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrines WHERE zoneID= :zoneID LIMIT 1');
        $req->execute(array('zoneID' => $zoneID));
        $shrineModel = $req->fetch();
        return new shrineModel($shrineModel);
    }

    public static function insertShrine($controller, $type){
        $db = db_conx::getInstance();
        $shrineID =intval($controller->getShrineID());
        $mapID = intval($controller->getMapID());
        $zoneID = intval($controller->getZoneID());
        $shrineType = intval($controller->getShrineType());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO shrines (mapID, zoneID, shrineType) VALUES (:mapID, :zoneID, :shrineType)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE shrines SET mapID= :mapID, zoneID= :zoneID, shrineType= :shrineType WHERE shrineID= :shrineID");
            $req->bindParam(':shrineID', $shrineID);
        }
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':shrineType', $shrineType);
        $req->execute();
    }

    public static function getMapShrines($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrines WHERE mapID= :mapID');
        $req->execute(array('mapID' => $mapID));
        $shrineModel = $req->fetchAll();
        $finalArray = [];
        $counter = 0;
        foreach ($shrineModel as $shrine){
            $temp = new shrineModel($shrine);
            $finalArray[$counter] = $temp;
            $counter++;
        }
        return $finalArray;
    }

    public static function getShrineDetails($shrineID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM shrineTypes WHERE typeKey= :type LIMIT 1');
        $req->execute(array('type' => $shrineID));
        $shrineModel = $req->fetch();
        return new shrineModel($shrineModel);
    }

    public static function getShrineNameOnly($shrineID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT typeName FROM shrineTypes WHERE typeKey= :type LIMIT 1');
        $req->execute(array('type' => $shrineID));
        $shrineModel = $req->fetch();
        return $shrineModel['typeName'];
    }

}