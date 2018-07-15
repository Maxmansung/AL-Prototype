<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/biomeType_Interface.php");
class biomeType implements biomeType_Interface
{
    protected $depth;
    protected $value;
    protected $description;
    protected $descriptionLong;
    protected $temperatureMod;
    protected $findingChanceMod;
    protected $finalType;
    protected $biomeImage;
    protected $biomeItems;
    protected $depletedTo;
    protected $visibleMap;

    public function __toString()
    {
        $output = $this->depth;
        $output .= '/ '.$this->value;
        $output .= '/ '.$this->description;
        $output .= '/ '.$this->descriptionLong;
        $output .= '/ '.$this->temperatureMod;
        $output .= '/ '.$this->findingChanceMod;
        $output .= '/ '.$this->finalType;
        $output .= '/ '.$this->biomeImage;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getDepth()
    {
        return $this->depth;
    }

    function setDepth($var)
    {
        $this->depth = $var;
    }

    function getValue()
    {
        return $this->value;
    }

    function setValue($var)
    {
        $this->value = $var;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getDescriptionLong()
    {
        return $this->descriptionLong;
    }

    function setDescriptionLong($var)
    {
        $this->descriptionLong = $var;
    }

    function getTemperatureMod()
    {
        return $this->temperatureMod;
    }

    function setTemperaturemod($var)
    {
        $this->temperatureMod = intval($var);
    }

    function getFindingChanceMod()
    {
        return $this->findingChanceMod;
    }

    function setFindingChangeMod($var)
    {
        $this->findingChanceMod = intval($var);
    }

    function getFinalType()
    {
        return $this->finalType;
    }

    function setFinalType($var)
    {
        $this->finalType = $var;
    }

    function getBiomeImage()
    {
        return $this->biomeImage;
    }

    function setBiomeImage($var)
    {
        $this->biomeImage = $var;
    }

    function getBiomeItems()
    {
        return $this->biomeItems;
    }

    function findItem()
    {
        $low = count($this->biomeItems);
        $count = rand(0,($low-1));
        return $this->biomeItems[$count];
    }

    function getDepletedTo()
    {
        return $this->depletedTo;
    }

    function setDepletedTo($var)
    {
        $this->depletedTo = $var;
    }

    function getVisibleMap()
    {
        return $this->visibleMap;
    }

    function setVisibleMap($var)
    {
        $this->visibleMap = $var;
    }

    //These are the land biomes that can be changed
    public static function getLandBiomes()
    {
        return array(1,2,3,4,7,9,10);
    }

    //These are the water biomes that can be changed
    public static function getWaterBiomes()
    {
        return array(5,6,8);
    }
}