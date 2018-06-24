<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/shrine_Interface.php");
class shrine implements shrine_Interface
{
    protected $shrineID;
    protected $shrineName;
    protected $description;
    protected $shrineIcon;
    protected $worshipCost;
    protected $worshipDescription;
    protected $minParty;
    protected $maxParty;
    protected $shrineBonus;
    protected $blessingMessage;
    protected $typeName;
    protected $shrineOverallType;
    protected $shrineAlertMessage;
    protected $shrineAlertTitle;


    public function __toString()
    {
        $output = $this->shrineID;
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

    function getTypeName()
    {
        return $this->typeName;
    }

    function setTypeName($var)
    {
        $this->typeName = $var;
    }

    function getOverallType()
    {
        return $this->shrineOverallType;
    }

    function setOverallType($var)
    {
        $this->shrineOverallType = $var;
    }

    function getShrineAlertMessage()
    {
        return $this->shrineAlertMessage;
    }

    function setShrineAlertMessage($var)
    {
        $this->shrineAlertMessage = $var;
    }

    function getShrineAlertTitle()
    {
        return $this->shrineAlertTitle;
    }

    function setShrineAlertTitle($var)
    {
        $this->shrineAlertTitle = $var;
    }

    protected function createShrineType($id){
        $object = "";
        switch ($id){
            case 1:
                $object = new shrineSolo();
                break;
            case 2:
                $object = new shrineTeam();
                break;
            case 3:
                $object = new shrineMap();
                break;
        }
        $this->setMaxParty($object->getMaxPlayers());
        $this->setMinParty($object->getMinPlayers());
        $this->setTypeName($object->getTypeName());
        $this->setOverallType($id);
    }

    function shrineRanks($map,$known){
        $results = "";
        switch ($this->getOverallType()){
            case 1:
                $results = shrineSolo::getCurrentRankings($map,$this,$known);
                break;
            case 2:
                $results = shrineTeam::getCurrentRankings($map,$this);
                break;
            case 3:
                $results = shrineMap::getCurrentRankings($map,$this);
                break;
        }
        return $results;
    }

    function checkShrineFavour($rankingsList,$personalID,$partyID){
        $result = "";
        switch ($this->getOverAllType()){
            case 1:
                $result = shrineSolo::checkIfFavoured($rankingsList,$personalID);
                break;
            case 2:
                $result = shrineTeam::checkIfFavoured($rankingsList,$partyID);
                break;
            case 3:
                $result = shrineMap::checkIfFavoured($rankingsList);
                break;
        }
        return $result;
    }
}