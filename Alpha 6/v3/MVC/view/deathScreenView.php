<?php
class deathScreenView
{

    protected $mapName;
    protected $partyName;
    protected $deathDay;
    protected $nightTemp;
    protected $survivableTemp;
    protected $gameType;
    protected $endType;
    protected $deathType;
    protected $achievements;
    protected $favourSolo;
    protected $favourTeam;
    protected $favourMap;


    function __construct($profileID)
    {
        $death = new deathScreenController($profileID);
        $this->mapName = $death->getMapID();
        $this->partyName = $death->getPartyName();
        $this->deathDay = $death->getDeathDay();
        $this->nightTemp = $death->getNightTemp();
        $this->survivableTemp = $death->getSurvivableTemp();
        $this->gameType = $death->getGameType();
        $this->endType = $death->getDayDuration();
        $typeName = "death".$death->getDeathType();
        $cause = new $typeName();
        $this->deathType = $cause->returnVars();
        $this->favourSolo = $death->getFavourSolo();
        $this->favourTeam = $death->getFavourTeam();
        $this->favourMap = $death->getFavourMap();
        if (is_array($death->getDeathAchievements())) {
            $this->achievements = achievementController::getAchievements($death->getDeathAchievements());
        } else {
            $this->achievements = [];
        }
    }

    function returnVars(){
        return get_object_vars($this);
    }


    static function getDeathView($profileID){
        $temp = new deathScreenView($profileID);
        return $temp->returnVars();
    }
}