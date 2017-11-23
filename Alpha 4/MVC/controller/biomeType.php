<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/interface/biomeType_Interface.php");
class biomeType implements biomeType_Interface
{
    protected $depth;
    protected $value;
    protected $description;
    protected $descriptionLong;
    protected $temperatureMod;
    protected $findingChanceMod;

    public function __toString()
    {
        $output = $this->depth;
        $output .= '/ '.$this->value;
        $output .= '/ '.$this->description;
        $output .= '/ '.$this->descriptionLong;
        $output .= '/ '.$this->temperatureMod;
        $output .= '/ '.$this->findingChanceMod;
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
}