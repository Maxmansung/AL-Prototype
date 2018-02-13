<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/controller/map.php");
require_once(PROJECT_ROOT."/MVC/model/mapModel.php");
class mapController extends map
{

    public function newmap($name,$player,$invent,$edge,$stamina,$length,$temp,$stemp,$tempm,$gameType)
    {
        $this->mapID = null;
        $this->name = $name;
        $this->maxPlayerCount = $player;
        $this->maxAvatarInventorySlots = $invent;
        $this->edgeSize = $edge;
        $this->maxAvatarStamina = $stamina;
        $this->dayDuration = $length;
        $this->currentDay = 1;
        $this->baseNightTemperature = $temp;
        $this->baseSurvivableTemperature = $stemp;
        $this->baseAvatarTemperatureModifier = $tempm;
        $this->temperatureRecord = [1=>$temp];
        $this->gameType = $gameType;
        $id = $this->postMap();
        echo "<br>MapID: ".$id;
        $this->mapID = $id;
    }

    //This updates a single map object on the database
    public function updateMap(){
        mapModel::insertMap($this, "Update");
    }

    //This function checks if there is already a map in the database with that name
    public function checkname($name){
        $mapmodel = mapModel::checkname($name);
        if ($mapmodel->name == $name) {
            return 1;
        } else {
            return 0;
        }
    }

    //This is used to create a unique MapID for the object
    public function createID()
    {
        $string = mapModel::newMapID();
        $idNum = preg_replace('#[^0-9]#', '', $string);
        $idNum++;
        $count = 5 - (strlen((string)$idNum));
        $finalmapid = "map";
        for ($x = 0; $x < $count; $x++) {
            $finalmapid .= "0";
        }
        $finalmapid .= $idNum;
        return $finalmapid;
    }

    //This function will create the map join screen
    public static function joingames(){
        $joingame = mapModel::allMaps();
        $counter = 0;
        $maplist = [];
        foreach ($joingame as $map){
            $maplist[$counter] = new mapController($map[0]);
            $counter += 1;
        }
        return $maplist;
    }

    //This posts the new map to the database
    public function postMap(){
        return mapModel::insertMap($this, "Insert");
    }

    public function __construct($id){
        if ($id != ""){
            $mapmodel = mapModel::checkmapID($id);
            $this->mapID = $mapmodel->getMapID();
            $this->name = $mapmodel->getName();
            $this->maxPlayerCount = $mapmodel->getMaxPlayerCount();
            $this->edgeSize = $mapmodel->getEdgeSize();
            $this->maxAvatarStamina = $mapmodel->getMaxPlayerStamina();
            $this->maxAvatarInventorySlots = $mapmodel->getMaxPlayerInventorySlots();
            $this->avatars = $mapmodel->getAvatars();
            $this->currentDay = $mapmodel->getCurrentDay();
            $this->dayDuration = $mapmodel->getDayDuration();
            $this->baseNightTemperature = $mapmodel->getBaseNightTemperature();
            $this->baseSurvivableTemperature = $mapmodel->getBaseSurvivableTemperature();
            $this->baseAvatarTemperatureModifier = $mapmodel->getBaseAvatarTemperatureModifier();
            $this->temperatureRecord = $mapmodel->getTemperatureRecord();
            $this->gameType = $mapmodel->getGameType();
        }
    }

    public static function createTimeStamp($timeSplit){
        if ($timeSplit<24 && $timeSplit>1){
            $time = self::lessThanADay($timeSplit);
        } elseif ($timeSplit <= 1){
            $time = self::lessThanAnHour($timeSplit);
        } else {
            $time = self::moreThanADay();
        }
        return $time;
    }

    private static function moreThanADay(){
        $time = strtotime("+1 day");
        $year = date("Y", $time);
        $month = date("m", $time);
        $day = date("d", $time);
        $finalTime = strtotime($year . "-" . $month . "-" . $day . " 22:00:00");
        return $finalTime;

    }

    private static function lessThanAnHour($timeSplit){
        $counter = 60*$timeSplit;
        $time =  strtotime("+".$counter." minutes");
        $year = date("Y", $time);
        $month = date("m", $time);
        $day = date("d", $time);
        $hour = date("G", $time);
        $minutes = date("i", $time);
        $finalTime = strtotime($year . "-" . $month . "-" . $day . " " .$hour.":".$minutes.":00");
        return $finalTime;

    }

    private static function lessThanADay($timeSplit){
        $time =  time();
        $hour = date("G",$time);
        $dateFound = false;
        $clock = 24;
        $advanceDay = false;
        $newHour = 0;
        while ($dateFound === false){
            if ($clock <= 0){
                $advanceDay = true;
                $newHour = $timeSplit;
                $dateFound = true;
            }
            if ($dateFound === false) {
                if ($clock - ($timeSplit-0.05) > $hour) {
                    if ($clock - (1.95 * $timeSplit) <= $hour) {
                        $newHour = $clock;
                        $dateFound = true;
                    }
                }
                $clock -= $timeSplit;
            }
        }
        if ($advanceDay === true) {
            $newTime = strtotime("+1 day");
            $year = date("Y", $newTime);
            $month = date("m", $newTime);
            $day = date("d", $newTime);;
        } else{
            $year = date("Y", $time);
            $month = date("m", $time);
            $day = date("d", $time);
        }
        $finalTime = strtotime($year . "-" . $month . "-" . $day . " " .$newHour.":00:00");
        return $finalTime;
    }

    public function createForestLocation($edge){
        $x = rand(2,$edge-2);
        $y = rand(2,$edge-2);
        return array($x,$y);
    }

    public function createShrineLocation($edge,$type){
        if ($type !== "Tutorial") {
            $shrineArray = array("S001", "S002", "S003");
        } else {
            $shrineArray = array("S001", "S004", "S003");
        }
        $finalArray = array();
        $counter = 0;
        foreach ($shrineArray as $shrine){
            $xAxis = true;
            $yAxis = true;
            while ($xAxis === true && $yAxis === true){
                $testX = rand(0,$edge-1);
                $testY = rand(0,$edge-1);
                $xAxis = false;
                $yAxis = false;
                foreach ($finalArray as $newShrine){
                    if ($testX === $newShrine[1]){
                        $xAxis = true;
                    }
                    if ($testY === $newShrine[2]){
                        $yAxis = true;
                    }
                }
            }
            $completedShrine = array($shrine,$testX,$testY);
            $finalArray[$counter] = $completedShrine;
            $counter++;
        }
        return $finalArray;
    }

    public function createLakeLocation($edge){
        $x = rand(0,$edge-1);
        $y = rand(0,$edge-1);
        $width = round($edge/4);
        return array($x,$y,$width);
    }

    public function deleteMap(){
        $response =  mapModel::deleteMap($this->mapID);
        if ($response == "SUCCESS"){
            return $this->name;
        } else {
            return "ERROR";
        }
    }

    public static function getAllMaps24hr(){
        $array = mapModel::allMapsOfTimeset("full");
        return $array;
    }
}