<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/interface/forumCatagories_Interface.php");
class forumCatagories implements forumCatagories_Interface
{
    protected $catagoryID;
    protected $catagoryName;
    protected $description;
    protected $flavourText;
    protected $accessType;

    public function __toString()
    {
        $output = $this->catagoryID;
        $output .= '/ '.$this->catagoryName;
        $output .= '/ '.$this->description;
        $output .= '/ '.$this->flavourText;
        $output .= '/ '.$this->accessType;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getCatagoryID()
    {
        return $this->catagoryID;
    }

    function setCatagoryID($var)
    {
        $this->catagoryID = $var;
    }

    function getCatagoryName()
    {
        return $this->catagoryName;
    }

    function setCatagoryName($var)
    {
        $this->catagoryName = $var;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getFlavourText()
    {
       return $this->flavourText;
    }

    function setFlavorText($var)
    {
        $this->flavourText = $var;
    }

    function getAccessType()
    {
        return $this->accessType;
    }

    function setAccessType($var)
    {
        $this->accessType = $var;
    }
}