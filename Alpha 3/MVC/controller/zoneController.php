<?
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/zone.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/zoneModel.php");
class zoneController extends zone
{

    public function __construct($id)
    {
        if ($id != ""){
            $zoneModel = zoneModel::findZoneID($id);
            $this->zoneID = $zoneModel->getZoneID();
            $this->name = $zoneModel->getName();
            $this->mapID = $zoneModel->getMapID();
            $this->coordinateX = $zoneModel->getCoordinateX();
            $this->coordinateY = $zoneModel->getCoordinateY();
            $this->avatars = $zoneModel->getAvatars();
            $this->items = $zoneModel->getItems();
            $this->buildings = $zoneModel->getBuildings();
            $this->controllingParty = $zoneModel->getControllingParty();
            $this->protectedZone = $zoneModel->isProtected();
            $this->storage = $zoneModel->getStorage();
            $this->findingChances = $zoneModel->getFindingChances();
            $this->biomeType = $zoneModel->getBiomeType();
            $this->zoneOutpostName = $zoneModel->getZoneOutpostName();
            $this->zoneSurvivableTemperatureModifier = $zoneModel->getZoneSurvivableTemperatureModifier();
            $this->counter = $zoneModel->getCounter();
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
        return new zoneController($model->getZoneID());
    }

    //This posts the new zone to the database
    public function postZone(){
        zoneModel::insertZone($this, "Insert");
    }

    //This posts the new zone to the database
    public function updateZone(){
        zoneModel::insertZone($this, "Update");
    }

    //This function creates a new zone object when a new map is being created
    public function newZone($mapID, $name, $x, $y,$forestLoc){
        $this->zoneID = $mapID.$name;
        $this->name = $name;
        $this->mapID = $mapID;
        $this->coordinateX = $x;
        $this->coordinateY = $y;
        $this->avatars = array();
        $this->items = array();
        $this->buildings = array();
        $this->controllingParty = "empty";
        $this->protectedZone = 0;
        $this->storage = "";
        $this->findingChances = $this->createFindingChances();
        $this->biomeType = $this->createBiomeType($forestLoc);
        $this->zoneOutpostName = 0;
        $this->zoneSurvivableTemperatureModifier = 0;
    }


    public function resetFindingChances(){
        $this->findingChances = self::createFindingChances();
    }

    //This creates the finding chances variable for new maps - currently set to do nothing
    private function createFindingChances(){
        return rand(5,10);
    }

    //This creates the biomeType for new maps - currently set to make all zones "snow"
    private function createBiomeType($forestLoc)
    {
        $biome = self::biomeForest($forestLoc);
        return $this->getBiomeID($biome);
    }

    //This creates a forest on the map
    private function biomeForest($forestLoc){
        $xLoc = $forestLoc[0];
        $yLoc = $forestLoc[1];
        $size = rand(2,3);
        $size2 = rand(3,4);
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
        $random = rand(1,4);
        if ($random === 3) {
            return "Scrub";
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
            default:
                return 1;
                break;
        }
    }


    //This returns an array of all the zones within a map
    public static function getAllZones($var){
        $zoneModel = zoneModel::findMapZones($var);
        $counter = 0;
        $zoneList = [];
        foreach ($zoneModel as $zone){
            $zoneList[$counter] = new zoneController($zone[0]);
            $counter += 1;
        }
        return $zoneList;
    }
}