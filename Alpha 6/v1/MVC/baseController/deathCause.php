<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/deathCause_Interface.php");
class deathCause implements deathCause_Interface
{
    protected $key;
    protected $causeName;
    protected $description;
    protected $image;

    public function returnVars(){
        return get_object_vars($this);
    }

    function getKey()
    {
        return $this->key;
    }

    function setKey($var)
    {
        $this->key = $var;
    }

    function getCauseName()
    {
        return $this->causeName;
    }

    function setCauseName($var)
    {
        $this->causeName = $var;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getImage()
    {
        return $this->image;
    }

    function setImage($var)
    {
        $this->image = $var;
    }
}