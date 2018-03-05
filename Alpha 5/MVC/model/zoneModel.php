<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class zoneModel extends zone
{

    private function __construct($zoneModel)
    {
        $this->zoneID = intval($zoneModel['zoneID']);
        $this->name = $zoneModel['name'];
        $this->mapID = intval($zoneModel['mapID']);
        $this->coordinateX = $zoneModel['coordinateX'];
        $this->coordinateY = $zoneModel['coordinateY'];
        $this->avatars = json_decode($zoneModel['avatars']);
        $this->buildings = json_decode($zoneModel['buildings']);
        $this->controllingParty = $zoneModel['controllingParty'];
        $this->protectedZoneType = $zoneModel['protectedZoneType'];
        $this->storage = $zoneModel['storageBuilt'];
        $this->findingChances = $zoneModel['findingChances'];
        $this->biomeType = $zoneModel['biomeType'];
        $this->zoneOutpostName = $zoneModel['zoneOutpostName'];
        $this->zoneSurvivableTemperatureModifier = $zoneModel['zoneSurvivableTemperatureModifier'];
        $this->counter = $zoneModel['counter'];
    }

    public static function findZoneID($zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Zone WHERE zoneID= :zoneID LIMIT 1');
        $req->execute(array('zoneID' => $zoneID));
        $zoneModel = $req->fetch();
        return new zoneModel($zoneModel);
    }

    public static function findMapZones($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT zoneID FROM Zone WHERE mapID= :mapID ORDER BY zoneID ASC');
        $req->bindParam(':mapID', $mapID);
        $req->execute();
        $zoneModel = $req->fetchAll();
        return $zoneModel;
    }

    public static function findZoneIDfromName($zoneID,$mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT zoneID FROM Zone WHERE mapID= :mapID AND name=:zoneID LIMIT 1');
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':zoneID', $zoneID);
        $req->execute();
        $zoneModel = $req->fetch();
        return intval($zoneModel["zoneID"]);
    }

    public static function findZoneCoords($zone){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT zoneID FROM Zone WHERE mapID= :mapID AND coordinateY= :coordY AND coordinateX= :coordX LIMIT 1');
        $req->bindParam(':mapID', $zone->getMapID());
        $req->bindParam(':coordY', $zone->getCoordinateY());
        $req->bindParam(':coordX', $zone->getCoordinateX());
        $req->execute();
        $zoneModel = $req->fetch();
        return new zoneModel($zoneModel);
    }

    public static function insertZone($controller, $type){
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Zone (zoneID, name, mapID, coordinateX, coordinateY, avatars, buildings, controllingParty, protectedZoneType, storageBuilt, findingChances, biomeType, zoneOutpostName, zoneSurvivableTemperatureModifier, counter) VALUES (:zoneID, :name2, :mapID, :coordinateX, :coordinateY, :avatars, :buildings, :controllingParty, :protectedZoneType, :storage2, :findingChances, :biomeType, :zoneOutpostName, :zoneSurvivableTemperatureModifier, :counter)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE Zone SET name= :name2, mapID= :mapID, coordinateX= :coordinateX, coordinateY= :coordinateY, avatars= :avatars, buildings= :buildings, controllingParty= :controllingParty, protectedZoneType= :protectedZoneType, storageBuilt= :storage2, findingChances= :findingChances, biomeType= :biomeType, zoneOutpostName= :zoneOutpostName, zoneSurvivableTemperatureModifier= :zoneSurvivableTemperatureModifier, counter= :counter WHERE zoneID= :zoneID");
        }
        $req->bindParam(':zoneID', $controller->getZoneID());
        $req->bindParam(':name2', $controller->getName());
        $req->bindParam(':mapID', intval($controller->getMapID()));
        $req->bindParam(':coordinateX', $controller->getCoordinateX());
        $req->bindParam(':coordinateY', $controller->getCoordinateY());
        $req->bindParam(':avatars', json_encode($controller->getAvatars()));
        $req->bindParam(':buildings', json_encode($controller->getBuildings()));
        $req->bindParam(':controllingParty', $controller->getControllingParty());
        $req->bindParam(':protectedZoneType', $controller->getProtectedType());
        $req->bindParam(':storage2', $controller->getStorage());
        $req->bindParam(':findingChances', $controller->getFindingChances());
        $req->bindParam(':biomeType', $controller->getBiomeType());
        $req->bindParam(':zoneOutpostName', $controller->getZoneOutpostName());
        $req->bindParam(':zoneSurvivableTemperatureModifier', $controller->getZoneSurvivableTemperatureModifier());
        $req->bindParam(':counter', $controller->getCounter());
        $req->execute();
        if ($type == "Insert"){
            return intval($db->lastInsertId());
        }
    }
}