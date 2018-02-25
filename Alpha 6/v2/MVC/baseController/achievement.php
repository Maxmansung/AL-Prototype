<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/achievement_Interface.php");
class achievement implements achievement_Interface
{
    protected $achievementID;
    protected $name;
    protected $description;
    protected $icon;
    protected $scoreAdjustment;


    function returnVars(){
        return get_object_vars($this);
    }

    function getAchievementID()
    {
        return $this->achievementID;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($var)
    {
        $this->name = $var;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getIcon()
    {
        return $this->icon;
    }

    function setIcon($var)
    {
        $this->icon = $var;
    }

    function getScoreAdjustment()
    {
        return $this->scoreAdjustment;
    }

    function setScoreAdjustment($var)
    {
        $this->scoreAdjustment = $var;
    }
}