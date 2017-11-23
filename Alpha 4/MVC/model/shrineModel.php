<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/connection/db_conx.php");
class shrineModel extends shrine
{
    private function __construct($shrineModel)
    {
        $this->shrineID = $shrineModel['shrineID'];
        $this->mapID = $shrineModel['mapID'];
        $this->zoneID = $shrineModel['zoneID'];
        $this->shrineType = $shrineModel['shrineType'];
        $this->history = get_object_vars(json_decode($shrineModel['history']));
        $this->currentArray = get_object_vars(json_decode($shrineModel['currentArray']));
        $this->shrineName = $shrineModel['typeName'];
        $this->description = $shrineModel['description'];
        $this->shrineIcon = $shrineModel['imageIcon'];
        $this->worshipCost = get_object_vars(json_decode($shrineModel['worshipCost']));
        $this->worshipDescription = $shrineModel['worshipDescription'];
        $this->minParty = intval($shrineModel['minParty']);
        $this->maxParty = intval($shrineModel['maxParty']);
        $this->shrineBonus = get_object_vars(json_decode($shrineModel['shrineBonus']));
        $this->blessingMessage = $shrineModel['blessingMessage'];
    }

    public static function getShrineByID($shrineID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT shrines.shrineID, shrines.shrineType, shrines.mapID, shrines.zoneID, shrines.history, shrines.currentArray, shrineTypes.typeKey, shrineTypes.typeName, shrineTypes.description, shrineTypes.imageIcon, shrineTypes.worshipCost, shrineTypes.worshipDescription, shrineTypes.minParty, shrineTypes.maxParty, shrineTypes.shrineBonus, shrineTypes.blessingMessage FROM shrines INNER JOIN shrineTypes ON shrines.shrineType = shrineTypes.typeKey AND shrineID= :shrineID LIMIT 1');
        $req->execute(array('shrineID' => $shrineID));
        $shrineModel = $req->fetch();
        return new shrineModel($shrineModel);
    }

    public static function findShrineInZone($zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT shrineID FROM shrines WHERE zoneID= :zoneID LIMIT 1');
        $req->execute(array('zoneID' => $zoneID));
        $shrineModel = $req->fetch();
        if ($shrineModel[0] === null){
            return false;
        } else {
            return $shrineModel["shrineID"];
        }
    }

    public static function getShrineByZone($zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT shrines.shrineID, shrines.shrineType, shrines.mapID, shrines.zoneID, shrines.history, shrines.currentArray, shrineTypes.typeKey, shrineTypes.typeName, shrineTypes.description, shrineTypes.imageIcon, shrineTypes.worshipCost, shrineTypes.worshipDescription, shrineTypes.minParty, shrineTypes.maxParty, shrineTypes.shrineBonus, shrineTypes.blessingMessage FROM shrines INNER JOIN shrineTypes ON shrines.shrineType = shrineTypes.typeKey AND zoneID= :zoneID LIMIT 1');
        $req->execute(array('zoneID' => $zoneID));
        $shrineModel = $req->fetch();
        return new shrineModel($shrineModel);
    }


    public static function insertShrine($controller, $type){
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO shrines (shrineID, mapID, zoneID, shrineType, history, currentArray) VALUES (:shrineID, :mapID, :zoneID, :shrineType, :history, :currentArray)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE shrines SET mapID= :mapID, zoneID= :zoneID, shrineType= :shrineType, history= :history, currentArray= :currentArray WHERE shrineID= :shrineID");;
        }
        $req->bindParam(':shrineID', $controller->getShrineID());
        $req->bindParam(':mapID', $controller->getMapID());
        $req->bindParam(':zoneID', $controller->getZoneID());
        $req->bindParam(':shrineType', $controller->getShrineType());
        $req->bindParam(':history', json_encode($controller->getHistory()));
        $req->bindParam(':currentArray', json_encode($controller->getCurrentArray()));
        $req->execute();
    }

    //This returns the next value in the counter columnn in order to add to the new item information
    public static function createShrineID(){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT shrineID FROM shrines ORDER BY shrineID DESC LIMIT 1');
        $req->execute();
        $tempID = $req->fetch();
        return $tempID['shrineID']+1;
    }

    public static function getMapShrineScores($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT shrineID FROM shrines WHERE mapID= :mapID');
        $req->execute(array('mapID' => $mapID));
        $shrineModel = $req->fetchAll();
        $idArray = [];
        foreach ($shrineModel as $shrine){
            array_push($idArray,$shrine["shrineID"]);
        }
        return $idArray;
    }

}