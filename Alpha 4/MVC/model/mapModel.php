<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/connection/db_conx.php");
class mapModel extends map
{
    private function __construct($mapmodel)
    {
        $this->mapID = $mapmodel['mapID'];
        $this->name = $mapmodel['name'];
        $this->maxPlayerCount = intval($mapmodel['maxPlayerCount']);
        $this->edgeSize = intval($mapmodel['edgeSize']);
        $this->maxAvatarStamina = intval($mapmodel['maxPlayerStamina']);
        $this->maxAvatarInventorySlots = intval($mapmodel['maxPlayerInventorySlots']);
        $this->avatars = json_decode($mapmodel['avatars']);
        $this->currentDay = intval($mapmodel['currentDay']);
        $this->dayDuration = floatval($mapmodel['dayDuration']);
        $this->baseNightTemperature = intval($mapmodel['baseNightTemperature']);
        $this->baseSurvivableTemperature = intval($mapmodel['baseSurvivableTemperature']);
        $this->baseAvatarTemperatureModifier = intval($mapmodel['basePlayerTemperatureModifier']);
        $this->dayEndTime = intval($mapmodel['dayEndTime']);
        $this->temperatureRecord = get_object_vars(json_decode($mapmodel['temperatureRecord']));
        $this->gameType = $mapmodel["gameType"];

    }

    public static function checkname($name) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Map WHERE name= :name LIMIT 1');
        // the query was prepared, now we replace :name with our actual $id value
        $req->execute(array('name' => $name));
        $mapmodel = $req->fetch();

        return new mapmodel($mapmodel);
    }

    public static function checkmapID($mapID) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Map WHERE mapID= :mapID LIMIT 1');
        // the query was prepared, now we replace :name with our actual $id value
        $req->execute(array('mapID' => $mapID));
        $mapmodel = $req->fetch();

        return new mapmodel($mapmodel);
    }

    public static function newMapID(){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT mapID FROM Map ORDER BY mapID DESC LIMIT 1");
        $req->execute();
        $mapmodel = $req->fetch();
        return $mapmodel[0];
    }

    public static function allMaps(){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM Map");
        $req->execute();
        $mapmodel = $req->fetchAll();
        return $mapmodel;
    }

    public static function insertMap($mapcontroller, $type){
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Map (mapID, name, maxPlayerCount, edgeSize, maxPlayerStamina, maxPlayerInventorySlots, avatars, currentDay, dayDuration, baseNightTemperature, baseSurvivableTemperature, basePlayerTemperatureModifier, dayEndTime, temperatureRecord, gameType) VALUES (:mapID, :name2, :maxPlayerCount, :edgeSize, :maxPlayerStamina, :maxPlayerInventorySlots, :avatars, :currentDay, :dayDuration, :baseNightTemperature, :baseSurvivableTemperature, :basePlayerTemperatureModifier, :dayEndTime, :temperatureRecord, :gameType)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Map SET name= :name2, maxPlayerCount= :maxPlayerCount, edgeSize= :edgeSize, maxPlayerStamina= :maxPlayerStamina, maxPlayerInventorySlots= :maxPlayerInventorySlots, avatars= :avatars, currentDay= :currentDay, dayDuration= :dayDuration, baseNightTemperature= :baseNightTemperature, baseSurvivableTemperature= :baseSurvivableTemperature, basePlayerTemperatureModifier= :basePlayerTemperatureModifier, dayEndTime= :dayEndTime, temperatureRecord= :temperatureRecord, gameType= :gameType WHERE mapID= :mapID");
        }
        $req->bindParam(':mapID', $mapcontroller->getMapID());
        $req->bindParam(':name2', $mapcontroller->getName());
        $req->bindParam(':maxPlayerCount', $mapcontroller->getMaxPlayerCount());
        $req->bindParam(':edgeSize', $mapcontroller->getEdgeSize());
        $req->bindParam(':maxPlayerStamina', $mapcontroller->getMaxPlayerStamina());
        $req->bindParam(':maxPlayerInventorySlots', $mapcontroller->getMaxPlayerInventorySlots());
        $req->bindParam(':avatars', json_encode($mapcontroller->getAvatars()));
        $req->bindParam(':currentDay', $mapcontroller->getCurrentDay());
        $req->bindParam(':dayDuration', $mapcontroller->getDayDuration());
        $req->bindParam(':baseNightTemperature', $mapcontroller->getBaseNightTemperature());
        $req->bindParam(':baseSurvivableTemperature', $mapcontroller->getBaseSurvivableTemperature());
        $req->bindParam(':basePlayerTemperatureModifier', $mapcontroller->getBaseAvatarTemperatureModifier());
        $req->bindParam(':dayEndTime', $mapcontroller->getDayEndTime());
        $req->bindParam(':temperatureRecord', json_encode($mapcontroller->getTemperatureRecord()));
        $req->bindParam(':gameType', $mapcontroller->getGameType());
        $req->execute();
    }



    public static function deleteMap($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM Map WHERE mapID= :mapID LIMIT 1');
        $req->execute(array('mapID' => $mapID));
        $req->fetch();
        return "SUCCESS";

    }
}