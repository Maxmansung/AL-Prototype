<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/interface/deathScreen_Interface.php");
class deathScreen implements deathScreen_Interface
{

    protected $profileID;
    protected $mapID;
    protected $partyName;
    protected $deathDay;
    protected $nightTemp;
    protected $survivableTemp;
    protected $deathStatistics;
    protected $deathAchievements;
    protected $gameType;
    protected $shrineScore;
    protected $deathType;
    protected $partyPlayersLeft;

    function returnVars(){
        return get_object_vars($this);
    }

    function getProfileID()
    {
        return $this->profileID;
    }

    function setProfileID($var)
    {
        $this->profileID = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getPartyName()
    {
        return $this->partyName;
    }

    function setPartyName($var)
    {
        $this->partyName = $var;
    }

    function getNightTemp()
    {
        return $this->nightTemp;
    }

    function setNightTemp($var)
    {
        $this->nightTemp = $var;
    }

    function getSurvivableTemp()
    {
        return $this->survivableTemp;
    }

    function setSurvivableTemp($var)
    {
        $this->survivableTemp = $var;
    }

    function getDeathStatistics()
    {
        return $this->deathStatistics;
    }

    function setDeathStatistics($var)
    {
        $this->deathStatistics = $var;
    }

    function getDeathAchievements()
    {
        return $this->deathAchievements;
    }

    function setDeathAchievements($var)
    {
        $this->deathAchievements = $var;
    }

    function getDeathDay()
    {
        return $this->deathDay;
    }

    function setDeathDay($var)
    {
        $this->deathDay = $var;
    }

    function getGameType(){
        return $this->gameType;
    }

    function setGameType($var){
        $this->gameType = $var;
    }

    function getShrineScore()
    {
        return $this->shrineScore;
    }

    function setShrineScore($var)
    {
        $this->shrineScore = $var;
    }

    function getDeathType()
    {
        return $this->deathType;
    }

    function setDeathType($var)
    {
        $this->deathType = $var;
    }

    function getPartyPlayersLeft()
    {
        return $this->partyPlayersLeft;
    }

    function setPartyPlayersLeft($var)
    {
        $this->partyPlayersLeft = $var;
    }
}