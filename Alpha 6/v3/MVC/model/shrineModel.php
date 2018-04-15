<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class shrineModel extends shrine
{
    private function __construct($shrineModel)
    {
        $this->shrineID = intval($shrineModel['shrineID']);
        $this->mapID = intval($shrineModel['mapID']);
        $this->zoneID = intval($shrineModel['zoneID']);
        $this->shrineType = $shrineModel['shrineType'];
        if (is_object(json_decode($shrineModel['history']))) {
            $this->history = get_object_vars(json_decode($shrineModel['history']));
        } else {
            $this->history = [];
        }
        if (is_object(json_decode($shrineModel['currentArray']))) {
            $this->currentArray = get_object_vars(json_decode($shrineModel['currentArray']));
        } else {
            $this->currentArray = [];
        }
        if (is_object(json_decode($shrineModel['worshipCost']))) {
            $this->worshipCost = get_object_vars(json_decode($shrineModel['worshipCost']));
        } else {
            $this->worshipCost = [];
        }
        if (is_object(json_decode($shrineModel['shrineBonus']))) {
            $this->shrineBonus = get_object_vars(json_decode($shrineModel['shrineBonus']));
        } else {
            $this->shrineBonus = [];
        }
        $this->shrineName = $shrineModel['typeName'];
        $this->description = $shrineModel['description'];
        $this->shrineIcon = $shrineModel['imageIcon'];
        $this->worshipDescription = $shrineModel['worshipDescription'];
        $this->minParty = intval($shrineModel['minParty']);
        $this->maxParty = intval($shrineModel['maxParty']);
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
        $shrineID =intval($controller->getShrineID());
        $mapID = intval($controller->getMapID());
        $zoneID = intval($controller->getZoneID());
        $shrineType = $controller->getShrineType();
        $history = json_encode($controller->getHistory());
        $currentArray = json_encode($controller->getCurrentArray());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO shrines (mapID, zoneID, shrineType, history, currentArray) VALUES (:mapID, :zoneID, :shrineType, :history, :currentArray)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE shrines SET mapID= :mapID, zoneID= :zoneID, shrineType= :shrineType, history= :history, currentArray= :currentArray WHERE shrineID= :shrineID");
            $req->bindParam(':shrineID', $shrineID);
        }
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':shrineType', $shrineType);
        $req->bindParam(':history', $history);
        $req->bindParam(':currentArray', $currentArray);
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