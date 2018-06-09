<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/zone_interface.php");
class zone implements zone_interface
{
    protected $zoneID = "";
    protected $name = "";
    protected $mapID = "";
    protected $coordinateX = 0;
    protected $coordinateY = 0;
    protected $avatars = array();
    protected $buildings = array();
    protected $controllingParty = "";
    protected $protectedZoneType = 0;
    protected $storage = "";
    protected $findingChances = 0;
    protected $biomeType = 0;
    protected $zoneOutpostName = 0;
    protected $zoneSurvivableTemperatureModifier = 0;
    protected $counter = 0;
    protected $lockBuilt;
    protected $lockStrength;
    protected $lockMax;
    protected $zoneItems = array();

    public function objectToArray(){
        return get_object_vars($this);
    }

    public function __toString()
    {
        $output = $this->zoneID;
        $output .= '/ '.$this->name;
        $output .= '/ '.$this->mapID;
        $output .= '/ '.$this->coordinateX;
        $output .= '/ '.$this->coordinateY;
        $output .= '/ '.json_encode($this->avatars);
        $output .= '/ '.json_encode($this->buildings);
        $output .= '/ '.$this->controllingParty;
        $output .= '/ '.$this->protectedZoneType;
        $output .= '/ '.$this->storage;
        $output .= '/ '.$this->findingChances;
        $output .= '/ '.$this->biomeType;
        $output .= '/ '.$this->zoneOutpostName;
        $output .= '/ '.$this->zoneSurvivableTemperatureModifier;
        $output .= '/ '.$this->counter;
        $output .= '/ '.$this->lockStrength;
        $output .= '/ '.$this->lockBuilt;
        $output .= '/ '.json_encode($this->zoneItems);
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getZoneID()
    {
        return $this->zoneID;
    }

    function setZoneID($var)
    {
        $this->zoneID = $var;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($var)
    {
        $this->name = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getCoordinateX()
    {
        return $this->coordinateX;
    }

    function setCoordinateX($var)
    {
        $this->coordinateX = $var;
    }

    function getCoordinateY()
    {
        return $this->coordinateY;
    }

    function setCoordinateY($var)
    {
        $this->coordinateY = $var;
    }

    function getAvatars()
    {
        return $this->avatars;
    }

    function setAvatars($var)
    {
        $this->avatars = $var;
    }

    function addAvatar($var)
    {
        if (is_array($this->avatars)) {
            array_push($this->avatars, $var);
            $this->avatars = array_values($this->avatars);
        } else {
            $this->avatars = [$var];
        }
    }

    function removeAvatar($var)
    {
        $key = array_search($var,$this->avatars);
        unset($this->avatars[$key]);
        $this->avatars = array_values($this->avatars);
    }

    function getBuildings()
    {
        return $this->buildings;
    }

    function setBuildings($var)
    {
        $this->buildings = $var;
    }

    function addBuilding($var)
    {
        array_push($this->buildings,$var);
        $this->buildings = array_values($this->buildings);
    }

    function removeBuilding($var)
    {
        $key = array_search($var,$this->buildings);
        unset($this->buildings[$key]);
        $this->buildings = array_values($this->buildings);
    }

    function getControllingParty()
    {
        return $this->controllingParty;
    }

    function setControllingParty($var)
    {
        $this->controllingParty = $var;
    }

    function getProtectedType()
    {
        return $this->protectedZoneType;
    }

    function setProtectedType($var)
    {
        $this->protectedZoneType = $var;
    }

    function getStorage()
    {
        return $this->storage;
    }

    function setStorage($var)
    {
        $int = intval($var);
        $this->storage = $int;
    }

    function getFindingChances()
    {
        return $this->findingChances;
    }

    function setFindingChances($var)
    {
        $this->findingChances = $var;
    }

    function reduceFindingChances(){
        $this->findingChances -= 1;
    }

    function getZoneOutpostName()
    {
        return $this->zoneOutpostName;
    }

    function setZoneOutpostName($var)
    {
        $this->zoneOutpostName = $var;
    }

    function getZoneSurvivableTemperatureModifier()
    {
        return $this->zoneSurvivableTemperatureModifier;
    }

    function setZoneSurvivableTemperatureModifier($var)
    {
        $this->zoneSurvivableTemperatureModifier = $var;
    }

    function getBiomeType()
    {
        return $this->biomeType;
    }

    function setBiomeType($var)
    {
        $this->biomeType = $var;
    }

    function getZoneNumber(){
        $number = ltrim($this->name,"z");
        return ltrim($number, "0");
    }

    function getCounter()
    {
        return $this->counter;
    }

    function setCounter($var)
    {
        $this->counter = $var;
    }

    function adjustCounter($var)
    {
        $this->counter += $var;
    }

    function getLockBuilt()
    {
        return $this->lockBuilt;
    }

    function setLockBuilt($var)
    {   
        $this->lockBuilt = $var;
    }

    function getLockStrength()
    {
        return $this->lockStrength;
    }

    function setLockStrength($var)
    {
        $this->lockStrength = $var;
    }

    function getLockMax()
    {
        return $this->lockMax;
    }

    function setLockMax($var)
    {
        $this->lockMax = $var;
    }

    function getZoneItems()
    {
        return $this->zoneItems;
    }

    function setZoneItems($var)
    {
        $this->zoneItems = $var;
    }

    function addItem($var){
        array_push($this->zoneItems, $var);
        $this->zoneItems = array_values($this->zoneItems);
    }

    function removeItem($var){
        if (in_array($var,$this->zoneItems)) {
            $key = array_search($var, $this->zoneItems);
            unset($this->zoneItems[$key]);
            $this->zoneItems = array_values($this->zoneItems);
        }
    }
}