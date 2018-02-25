<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/map_Interface.php");
class map implements map_interface
{
    protected $mapID = "A";
    protected $name = "";
    protected $maxPlayerCount = 0;
    protected $edgeSize = 0;
    protected $maxAvatarStamina = 0;
    protected $maxAvatarInventorySlots = 0;
    protected $avatars = [];
    protected $currentDay = 0;
    protected $dayDuration = 0;
    protected $baseNightTemperature = 0;
    protected $baseSurvivableTemperature = 0;
    protected $baseAvatarTemperatureModifier = 0;
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
        $output .= '/ '.$this->currentDay;
        $output .= '/ '.$this->dayDuration;
        $output .= '/ '.$this->baseNightTemperature;
        $output .= '/ '.$this->baseSurvivableTemperature;
        $output .= '/ '.$this->baseAvatarTemperatureModifier;
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