<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/interface/shrine_Interface.php");
class shrine implements shrine_Interface
{

    protected $shrineID;
    protected $mapID;
    protected $zoneID;
    protected $shrineType;
    protected $history;
    protected $currentArray;
    protected $shrineName;
    protected $description;
    protected $shrineIcon;
    protected $worshipCost;
    protected $worshipDescription;
    protected $currentArrayView;
    protected $totalTribute;
    protected $minParty;
    protected $maxParty;
    protected $shrineBonus;
    protected $blessingMessage;


    public function __toString()
    {
        $output = $this->shrineID;
        $output .= '/ '.$this->mapID;
        $output .= '/ '.$this->zoneID;
        $output .= '/ '.$this->shrineType;
        $output .= '/ '.$this->history;
        $output .= '/ '.$this->currentArray;
        $output .= '/ '.$this->shrineName;
        $output .= '/ '.$this->description;
        $output .= '/ '.$this->shrineIcon;
        $output .= '/ '.$this->worshipCost;
        $output .= '/ '.$this->worshipDescription;
        $output .= '/ '.$this->minParty;
        $output .= '/ '.$this->maxParty;
        $output .= '/ '.$this->shrineBonus;
        $output .= '/ '.$this->blessingMessage;
        return $output;
    }

    public function returnVars(){
        return get_object_vars($this);
    }

    function getShrineID()
    {
        return $this->shrineID;
    }

    function setShrineID($var)
    {
        $this->shrineID = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getZoneID()
    {
        return $this->zoneID;
    }

    function setZoneID($var)
    {
        $this->zoneID = $var;
    }

    function getShrineType()
    {
        return $this->shrineType;
    }

    function setShrineType($var)
    {
        $this->shrineType = $var;
    }

    function getHistory()
    {
        return $this->history;
    }

    function setHistory($var)
    {
        $this->history = $var;
    }

    function addHistory($key, $var)
    {
        if (key_exists($key,$this->history)){
            $current = intval($this->history[$key]);
            $this->history[$key] = $current + intval($var);
        } else {
            $this->history[$key] = $var;
        }
    }

    function getHistoryDay($key){
        return $this->history[$key];
    }

    function getCurrentArray()
    {
        return $this->currentArray;
    }

    function setCurrentArray($var)
    {
        $this->currentArray = $var;
    }

    function addCurrentArray($key, $var)
    {
       if (key_exists($key,$this->currentArray)){
           $current = intval($this->currentArray[$key]);
           $this->currentArray[$key] = $current + intval($var);
       } else {
           $this->currentArray[$key] = $var;
       }
    }

    function getShrineName()
    {
        return $this->shrineName;
    }

    function setShrineName($var)
    {
        $this->shrineName = $var;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getShrineIcon()
    {
        return $this->shrineIcon;
    }

    function setShrineIcon($var)
    {
        $this->shrineIcon = $var;
    }

    function getWorshipCost()
    {
        return $this->worshipCost;
    }

    function setWorshipCost($var)
    {
        $this->worshipCost = $var;
    }

    function getWorshipCostType()
    {
        $counter = 0;
        $returnVal = "ERROR";
        foreach ($this->worshipCost as $key => $value){
            if ($counter === 0){
                $returnVal = $key;
            }
            $counter++;
        }
        return $returnVal;
    }

    function getWorshipCostValue()
    {
        $counter = 0;
        $returnVal = "ERROR";
        foreach ($this->worshipCost as $key => $value){
            if ($counter === 0){
                $returnVal = $value;
            }
            $counter++;
        }
        return $returnVal;
    }

    function getWorshipDescription()
    {
        return $this->worshipDescription;
    }

    function setWorshipDescription($var)
    {
        $this->worshipDescription = $var;
    }

    function calculateTotalTribute(){
        $total = 0;
        foreach ($this->currentArray as $value){
            $total += $value;
        }
        $this->totalTribute = $total;
    }

    function getTotalTribute(){
        return $this->totalTribute;
    }

    function getMinParty()
    {
        return $this->minParty;
    }

    function setMinParty($var)
    {
        $this->minParty = $var;
    }

    function getMaxParty()
    {
        return $this->maxParty;
    }

    function setMaxParty($var)
    {
        $this->maxParty = $var;
    }

    function getShrineBonus()
    {
        return $this->shrineBonus;
    }

    function setShrineBonus($var)
    {
        $this->shrineBonus = $var;
    }

    function getShrineBonusType()
    {
        $counter = 0;
        $returnVal = "ERROR";
        foreach ($this->shrineBonus as $key => $value){
            if ($counter === 0){
                $returnVal = $key;
            }
            $counter++;
        }
        return $returnVal;
    }

    function getShrineBonusReward()
    {
        return $this->shrineBonus[$this->getShrineBonusType()];
    }

    function getBlessingMessage()
    {
        return $this->blessingMessage;
    }

    function setBlessingMessage($var)
    {
        $this->blessingMessage = $var;
    }
}