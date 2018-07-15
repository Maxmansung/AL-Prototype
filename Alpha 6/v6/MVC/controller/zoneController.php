<?
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/zone.php");
require_once(PROJECT_ROOT."/MVC/model/zoneModel.php");
class zoneController extends zone
{

    public function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)){
                $zoneModel = $id;
            } else {
                $zoneModel = zoneModel::findZoneID($id);
            }
            $this->zoneID = $zoneModel->getZoneID();
            $this->name = $zoneModel->getName();
            $this->mapID = $zoneModel->getMapID();
            $this->coordinateX = $zoneModel->getCoordinateX();
            $this->coordinateY = $zoneModel->getCoordinateY();
            $this->avatars = $zoneModel->getAvatars();
            $this->buildings = $zoneModel->getBuildings();
            $this->controllingParty = $zoneModel->getControllingParty();
            $this->protectedZoneType = $zoneModel->getProtectedType();
            $this->storage = $zoneModel->getStorage();
            $this->findingChances = $zoneModel->getFindingChances();
            $this->biomeType = $zoneModel->getBiomeType();
            $this->zoneOutpostName = $zoneModel->getZoneOutpostName();
            $this->zoneSurvivableTemperatureModifier = $zoneModel->getZoneSurvivableTemperatureModifier();
            $this->counter = $zoneModel->getCounter();
            $this->lockBuilt = $zoneModel->getLockBuilt();
            $this->lockStrength = $zoneModel->getLockStrength();
            $this->lockMax = $zoneModel->getLockMax();
            $this->zoneItems = $zoneModel->getZoneItems();
        }
    }

    public function nextMap($dir){
        switch ($dir){
            case "n":
                $this->coordinateY += 1;
                break;
            case "e":
                $this->coordinateX += 1;
                break;
            case "s":
                $this->coordinateY -= 1;
                break;
            case "w":
                $this->coordinateX -= 1;
                break;
        }
        $model = zoneModel::findZoneCoords($this);
        return new zoneController($model);
    }

    //This posts the new zone to the database
    public function postZone(){
        return zoneModel::insertZone($this, "Insert");
    }

    //This posts the new zone to the database
    public function updateZone(){
        zoneModel::insertZone($this, "Update");
    }

    //This function creates a new zone object when a new map is being created
    public function newZone($mapID, $name, $x, $y,$forestLoc,$shrineLoc,$lakeLoc){
        $this->zoneID = null;
        $this->name = $name;
        $this->mapID = $mapID;
        $this->coordinateX = $x;
        $this->coordinateY = $y;
        $this->avatars = array();
        $this->buildings = array();
        $this->controllingParty = null;
        $this->protectedZoneType = "none";
        $this->storage = "";
        $this->findingChances = $this->createFindingChances();
        $this->biomeType = $this->createBiomeType($forestLoc,$shrineLoc,$lakeLoc);
        $this->zoneOutpostName = 0;
        $this->zoneSurvivableTemperatureModifier = 0;
        $this->lockBuilt = 0;
        $this->lockStrength = 0;
        $this->lockMax = 0;
        $this->zoneItems = array();
        $this->postZone();
    }


    public function resetFindingChances(){
        $this->findingChances = self::createFindingChances();
    }

    //This creates the finding chances variable for new maps - currently set to do nothing
    private function createFindingChances(){
        return rand(7,15);
    }

    //This creates the biomeType for new maps - currently set to make all zones "snow"
    private function createBiomeType($forestLoc,$shrineLoc,$lakeLoc)
    {
        $biome = self::biomeForest($forestLoc,$shrineLoc,$lakeLoc);
        return $this->getBiomeID($biome);
    }

    //This creates a forest on the map
    private function biomeForest($forestLoc,$shrineLoc,$lakeLoc){
        $xLoc = $forestLoc[0];
        $yLoc = $forestLoc[1];
        $xLake = $lakeLoc[0];
        $yLake = $lakeLoc[1];
        $sizeLake = $lakeLoc[2];
        $size = rand(2,3);
        $size2 = rand(3,4);
        foreach ($shrineLoc as $shrine){
            if ($this->getCoordinateX() == $shrine[1]){
                if ($this->getCoordinateY() == $shrine[2]){
                    $this->setProtectedType($shrine[0]);
                    return "Shrine";
                }
            }
        }
        if($this->coordinateX>=$xLake && $this->coordinateX<$xLake+$sizeLake){
            if($this->coordinateY>=$yLake && $this->coordinateY<$yLake+$sizeLake){
                if(rand(0,2) !== 0){
                    return "Ice";
                }
            }
        }
        if ($this->coordinateX<($xLoc+$size) && $this->coordinateX>($xLoc-$size)){
            if ($this->coordinateY<($yLoc+$size) && $this->coordinateY>($yLoc-$size)){
                return "Forest";
            }
        }
        if ($this->coordinateX<($xLoc+$size2) && $this->coordinateX>($xLoc-$size2)){
            if ($this->coordinateY<($yLoc+$size2) && $this->coordinateY>($yLoc-$size2)){
                return "Scrub";
            }
        }
        $random = rand(1,6);
        if ($random === 3) {
            return "Scrub";
        } else if ($random === 2 || $random === 4){
            return "Bone";
        } else {
            return "Snow";
        }
    }

    //This converts the biome words into the correct biomeType
    private function getBiomeID($biomeName){
        switch ($biomeName){
            case "Forest":
                return 4;
                break;
            case "Scrub":
                return 3;
                break;
            case "Snow":
                return 2;
                break;
            case "Soil":
                return 1;
                break;
            case "Lake":
                return 5;
                break;
            case "Ice":
                return 6;
                break;
            case "Bone":
                return 7;
            case "Shrine":
                return 100;
            default:
                return 1;
                break;
        }
    }

    public static function getZoneIDfromName($zoneID,$mapID){
        return zoneModel::findZoneIDfromName($zoneID,$mapID);
    }


    //This returns an array of all the zones within a map
    public static function getAllZones($mapID,$object){
        $zoneModel = zoneModel::findMapZones($mapID);
        $zoneList = [];
        foreach ($zoneModel as $zone){
            $temp = new zoneController($zone);
            if ($object === false){
                $zoneList[$temp->getZoneID()] = $temp->returnVars();
            } else {
                $zoneList[$temp->getZoneID()] = $temp;
            }
        }
        return $zoneList;
    }

    public static function getMapShrines($mapID){
        $list = zoneModel::getMapShrines($mapID);
        $finalArray = [];
        foreach ($list as $zone){
            $name = "shrine".$zone->getProtectedType();
            $shrine = new $name();
            $finalArray[$shrine->getShrineID()] = $shrine;
        }
        return $finalArray;
    }
}