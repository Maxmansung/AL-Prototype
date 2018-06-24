<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/storage_Interface.php");
class storage implements storage_Interface
{
    protected $storageID;
    protected $zoneID;
    protected $items;
    protected $maximumCapacity;
    protected $storageLevel;
    protected $lockBuilt;
    protected $lockStrength;
    protected $lockMax;

    public function __toString()
    {
        $output = $this->storageID;
        $output .= '/ '.$this->zoneID;
        $output .= '/ '.$this->items;
        $output .= '/ '.$this->maximumCapacity;
        $output .= '/ '.$this->storageLevel;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getStorageID(){
        return $this->storageID;
    }

    function setStorageID($var){
        $this->storageID = $var;
    }

    function getZoneID(){
        return $this->zoneID;
    }

    function setZoneID($var){
        $this->zoneID = $var;
    }

    function getItems(){
        return $this->items;
    }

    function setItems($var){
        $this->items = $var;
    }

    function addItem($var)
    {
        array_push($this->items, $var);
        $this->items = array_values($this->items);
    }

    function removeItem($var){
        if (in_array($var,$this->items)) {
            $key = array_search($var, $this->items);
            unset($this->items[$key]);
            $this->items = array_values($this->items);
        }
    }

    function getMaximumCapacity(){
        return $this->maximumCapacity;
    }

    function setMaximumCapacity($var){
        $this->maximumCapacity = $var;
    }

    function getStorageLevel(){
        return $this->storageLevel;
    }

    function setStorageLevel($var){
        $this->storageLevel = $var;
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
}