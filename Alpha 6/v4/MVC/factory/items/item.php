<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/item_Interface.php");
class item implements item_Interface
{

    protected $itemID;
    protected $mapID;
    protected $itemTemplateID;
    protected $identity;
    protected $icon;
    protected $description;
    protected $itemType;
    protected $usable;
    protected $survivalBonus;
    protected $givesRecipe;

    public function __toString()
    {
        $output = $this->itemID;
        $output .= '/ '.$this->mapID;
        $output .= '/ '.$this->itemTemplateID;
        $output .= '/ '.$this->identity;
        $output .= '/ '.$this->icon;
        $output .= '/ '.$this->description;
        $output .= '/ '.$this->itemType;
        $output .= '/ '.$this->usable;
        $output .= '/ '.$this->survivalBonus;
        return $output;
    }

    function returnVars()
    {
        return get_object_vars($this);
    }


    function getItemID()
    {
        return $this->itemID;
    }

    function setItemID($var)
    {
        $this->itemID = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getItemTemplateID()
    {
        return $this->itemTemplateID;
    }

    function setItemTemplateID($var)
    {
        $this->itemTemplateID = $var;
    }

    function getIcon()
    {
        return $this->icon;
    }

    function setIcon($var)
    {
        $this->icon = $var;
    }

    function getItemType()
    {
        return $this->itemType;
    }

    function setItemType($var)
    {
        $this->itemType = $var;
    }

    function getUsable()
    {
        return $this->usable;
    }

    function setUsable($var)
    {
        $this->usable = $var;
    }

    function getIdentity()
    {
        return $this->identity;
    }

    function setIdentity($var)
    {
        $this->identity = $var;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getSurvivalBonus()
    {
        return $this->survivalBonus;
    }

    function setSurvivalBonus($var)
    {
        $this->survivalBonus = $var;
    }

    function getGivesRecipe()
    {
        return $this->givesRecipe;
    }

    function setGivesRecipe($var)
    {
        $this->givesRecipe = $var;
    }
}