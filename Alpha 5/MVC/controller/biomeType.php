<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/interface/biomeType_Interface.php");
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
}