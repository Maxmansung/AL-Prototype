<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class mapModel extends map
{
    private function __construct($mapmodel)
    {
        $this->mapID = intval($mapmodel['mapID']);
        $this->name = $mapmodel['name'];
        $this->maxPlayerCount = intval($mapmodel['maxPlayerCount']);
        $this->edgeSize = intval($mapmodel['edgeSize']);
        $this->maxAvatarStamina = intval($mapmodel['maxPlayerStamina']);
        $this->maxAvatarInventorySlots = intval($mapmodel['maxPlayerInventorySlots']);
        $this->avatars = json_decode($mapmodel['avatars']);
        $this->currentDay = intval($mapmodel['currentDay']);
        $this->dayDuration = $mapmodel['dayDuration'];
        $this->baseNightTemperature = intval($mapmodel['baseNightTemperature']);
        $this->baseSurvivableTemperature = intval($mapmodel['baseSurvivableTemperature']);
        $this->baseAvatarTemperatureModifier = intval($mapmodel['basePlayerTemperatureModifier']);
        if (is_object(json_decode($mapmodel['temperatureRecord']))){
            $this->temperatureRecord = get_object_vars(json_decode($mapmodel['temperatureRecord']));
        } else {
            $this->temperatureRecord = json_decode($mapmodel['temperatureRecord']);
        }
        $this->gameType = intval($mapmodel["gameType"]);
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
        $final = [];
        $counter = 0;
        foreach ($mapmodel as $map){
            $temp = new mapModel($map);
            $final[$counter] = $temp;
            $counter++;
        }
        return $final;
    }

    public static function insertMap($mapcontroller, $type){
        $db = db_conx::getInstance();
        $mapID = intval($mapcontroller->getMapID());
        $name2 = $mapcontroller->getName();
        $maxPlayerCount = intval($mapcontroller->getMaxPlayerCount());
        $edgeSize = intval($mapcontroller->getEdgeSize());
        $maxPlayerStamina = intval($mapcontroller->getMaxPlayerStamina());
        $maxPlayerInventorySlots = intval($mapcontroller->getMaxPlayerInventorySlots());
        $avatars = json_encode($mapcontroller->getAvatars());
        $currentDay = intval($mapcontroller->getCurrentDay());
        $dayDuration = $mapcontroller->getDayDuration();
        $baseNightTemperature = intval($mapcontroller->getBaseNightTemperature());
        $baseSurvivableTemperature = intval($mapcontroller->getBaseSurvivableTemperature());
        $basePlayerTemperatureModifier = intval($mapcontroller->getBaseAvatarTemperatureModifier());
        $temperatureRecord = json_encode($mapcontroller->getTemperatureRecord());
        $gameType = intval($mapcontroller->getGameType());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Map (name, maxPlayerCount, edgeSize, maxPlayerStamina, maxPlayerInventorySlots, avatars, currentDay, dayDuration, baseNightTemperature, baseSurvivableTemperature, basePlayerTemperatureModifier, temperatureRecord, gameType) VALUES (:name2, :maxPlayerCount, :edgeSize, :maxPlayerStamina, :maxPlayerInventorySlots, :avatars, :currentDay, :dayDuration, :baseNightTemperature, :baseSurvivableTemperature, :basePlayerTemperatureModifier, :temperatureRecord, :gameType)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Map SET name= :name2, maxPlayerCount= :maxPlayerCount, edgeSize= :edgeSize, maxPlayerStamina= :maxPlayerStamina, maxPlayerInventorySlots= :maxPlayerInventorySlots, avatars= :avatars, currentDay= :currentDay, dayDuration= :dayDuration, baseNightTemperature= :baseNightTemperature, baseSurvivableTemperature= :baseSurvivableTemperature, basePlayerTemperatureModifier= :basePlayerTemperatureModifier, temperatureRecord= :temperatureRecord, gameType= :gameType WHERE mapID= :mapID");
            $req->bindParam(':mapID', $mapID);
        }
        $req->bindParam(':name2', $name2);
        $req->bindParam(':maxPlayerCount', $maxPlayerCount);
        $req->bindParam(':edgeSize', $edgeSize);
        $req->bindParam(':maxPlayerStamina', $maxPlayerStamina);
        $req->bindParam(':maxPlayerInventorySlots', $maxPlayerInventorySlots);
        $req->bindParam(':avatars', $avatars);
        $req->bindParam(':currentDay', $currentDay);
        $req->bindParam(':dayDuration', $dayDuration);
        $req->bindParam(':baseNightTemperature', $baseNightTemperature);
        $req->bindParam(':baseSurvivableTemperature', $baseSurvivableTemperature);
        $req->bindParam(':basePlayerTemperatureModifier', $basePlayerTemperatureModifier);
        $req->bindParam(':temperatureRecord', $temperatureRecord);
        $req->bindParam(':gameType', $gameType);
        $req->execute();
        if ($type == "Insert"){
            $test = $db->lastInsertId();
            return $test;
        }
    }



    public static function deleteMap($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM Map WHERE mapID= :mapID LIMIT 1');
        $req->execute(array('mapID' => $mapID));
        $req->fetch();
        return "SUCCESS";

    }

    public static function allMapsOfTimeset($timer){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT mapID FROM Map WHERE dayDuration= :timer");
        $req->execute(array('timer' => $timer));
        $mapmodel = $req->fetchAll();
        $finalArray = [];
        foreach ($mapmodel as $map){
            array_push($finalArray,$map[0]);
        }
        return $finalArray;
    }

    public static function getTutorialMap(){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM Map WHERE gameType= 'Tutorial' ORDER BY mapID DESC LIMIT 5");
        $req->execute();
        $mapmodel = $req->fetchAll();
        $final = 0;
        foreach ($mapmodel as $map){
            $mapModel = new mapModel($map);
            if (count($mapModel->getAvatars())==0){
                $final = $mapModel->getMapID();
            }
        }
        return $final;
    }


}