<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrineType
{
    protected $minPlayers;
    protected $maxPlayers;
    protected $typeName;
    protected $typeDescription;

    static $soloShrines = [1];
    static $teamShrines = [2];
    static $mapShrines = [3];

    static $soloCountedPlayers = 3;
    static $teamCountedPlayers = 1;

    function getMinPlayers(){
        return $this->minPlayers;
    }

    function getMaxPlayers(){
        return $this->maxPlayers;
    }

    function getTypeName(){
        return $this->typeName;
    }

    function getTypeDescription(){
        return $this->typeDescription;
    }
}