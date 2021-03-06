<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/interface/map_Interface.php");
class map implements map_interface
{
    protected $mapID = "A";
    protected $name = "";
    protected $maxPlayerCount = 0;
    protected $edgeSize = 0;
    protected $maxAvatarStamina = 0;
    protected $maxAvatarInventorySlots = 0;
    protected $avatars = [];
    protected $groups = [];
    protected $zones = [];
    protected $currentDay = 0;
    protected $dayDuration = 0;
    protected $baseNightTemperature = 0;
    protected $baseSurvivableTemperature = 0;
    protected $baseAvatarTemperatureModifier = 0;
    protected $dayEndTime;
    protected $temperatureRecord;
    protected $gameType;

    public function __toString()
    {
        $output = $this->mapID;
        $output .= '/ '.$this->name;
        $output .= '/ '.$this->maxPlayerCount;
        $output .= '/ '.$this->edgeSize;
        $output .= '/ '.$this->maxAvatarStamina;
        $output .= '/ '.$this->maxAvatarInventorySlots;
        $output .= '/ '.$this->avatars;
        $output .= '/ '.$this->groups;
        $output .= '/ '.$this->zones;
        $output .= '/ '.$this->currentDay;
        $output .= '/ '.$this->dayDuration;
        $output .= '/ '.$this->baseNightTemperature;
        $output .= '/ '.$this->baseSurvivableTemperature;
        $output .= '/ '.$this->baseAvatarTemperatureModifier;
        $output .= '/ '.$this->dayEndTime;
        $output .= '/ '.$this->temperatureRecord;
        $output .= '/ '.$this->gameType;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($var)
    {
        $this->name = $var;
    }

    function getMaxPlayerCount()
    {
        return $this->maxPlayerCount;
    }

    function setMaxPlayerCount($var)
    {
        $this->maxPlayerCount = intval($var);
    }

    function getEdgeSize()
    {
        return $this->edgeSize;
    }

    function setEdgeSize($var)
    {
        $this->edgeSize = intval($var);
    }

    function getMaxPlayerStamina()
    {
        return $this->maxAvatarStamina;
    }

    function setMaxPlayerStamina($var)
    {
        $this->maxAvatarStamina = intval($var);
    }

    function getMaxPlayerInventorySlots()
    {
        return $this->maxAvatarInventorySlots;
    }

    function setMaxPlayerInventorySlots($var)
    {
        $this->maxAvatarInventorySlots = intval($var);
    }

    function getAvatars()
    {
        return array_values($this->avatars);
    }

    function setAvatars($var)
    {
        $this->avatars = $var;
    }

    function addAvatar($var)
    {
        array_push($this->avatars,$var);
        $this->avatars = array_values($this->avatars);
    }

    function removeAvatar($var)
    {
        $key = array_search($var,$this->avatars);
        unset($this->avatars[$key]);
        $this->avatars = array_values($this->avatars);
    }

    function getGroup()
    {
        return $this->groups;
    }

    function setGroup($var)
    {
        $this->groups = $var;
    }

    function addGroup($var)
    {
        array_push($this->groups,$var);
        $this->groups = array_values($this->groups);
    }

    function removeGroup($var)
    {
        $key = array_search($var,$this->groups);
        unset($this->groups[$key]);
        $this->groups = array_values($this->groups);
    }

    function getZone()
    {
        return $this->zones;
    }

    function setZone($var)
    {
        $this->zones = $var;
    }

    function addZone($var)
    {
        array_push($this->zones,$var);
        $this->zones = array_values($this->zones);
    }

    function removeZone($var)
    {
        array_push($this->zones,$var);
        $this->zones = array_values($this->zones);
    }

    function getCurrentDay()
    {
        return $this->currentDay;
    }

    function setCurrentDay($var)
    {
        $this->currentDay = intval($var);
    }

    function increaseCurrentDay(){
        $this->currentDay = $this->currentDay +1;
    }

    function getDayDuration()
    {
        return $this->dayDuration;
    }

    function setDayDuration($var)
    {
        $this->dayDuration = $var;
    }

    function getBaseNightTemperature()
    {
        return $this->baseNightTemperature;
    }

    function setBaseNightTemperature($var)
    {
        $this->baseNightTemperature = intval($var);
    }

    function getBaseSurvivableTemperature()
    {
        return $this->baseSurvivableTemperature;
    }

    function setBaseSurvivableTemperature($var)
    {
        $this->baseSurvivableTemperature = intval($var);
    }

    function getBaseAvatarTemperatureModifier()
    {
        return $this->baseAvatarTemperatureModifier;
    }

    function setBaseAvatarTemperatureModifier($var)
    {
        $this->baseAvatarTemperatureModifier = intval($var);
    }

    function getDayEndTime()
    {
        return $this->dayEndTime;
    }

    function setDayEndTime($var)
    {
        $this->dayEndTime = intval($var);
    }

    function getTemperatureRecord()
    {
        return $this->temperatureRecord;
    }

    function setTemperatureRecord($var)
    {
        $this->temperatureRecord = $var;
    }

    function addTemperatureRecord($day, $var)
    {
        if(!key_exists($day,$this->temperatureRecord)){
            $this->temperatureRecord[$day] = $var;
        }
    }

    function getSingleTemperatureRecord($day){
        return $this->temperatureRecord[$day];
    }

    function getGameType(){
        return $this->gameType;
    }

    function setGameType($var){
        $this->gameType = $var;
    }
}