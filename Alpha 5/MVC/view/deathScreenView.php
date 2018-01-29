<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class deathScreenView
{
    protected $profileID;
    protected $mapName;
    protected $partyName;
    protected $deathDay;
    protected $nightTemp;
    protected $survivableTemp;
    protected $deathStatistics;
    protected $achievementDetails;
    protected $gameType;
    protected $shrineDisplay;
    protected $deathType;
    protected $deathDescription;
    protected $deathImage;

    public function __construct($profileID)
    {
            $deathModel = new deathScreenController($profileID);
            $this->profileID = $deathModel->getProfileID();
            $map = new mapController($deathModel->getMapID());
            $this->mapName = $map->getName();
            $this->partyName = $deathModel->getPartyName();
            $this->deathDay = $deathModel->getDeathDay();
            $this->nightTemp = $deathModel->getNightTemp();
            $this->survivableTemp = $deathModel->getSurvivableTemp();
            $this->deathStatistics = $deathModel->getDeathStatistics();
            $this->achievementDetails = achievementController::getAchievements($deathModel->getDeathAchievements());
            $this->gameType = $deathModel->getGameType();
            $this->shrineDisplay = buildingLevels::getShrineDetails($deathModel->getShrineScore());
            $cause = new deathCauseController($deathModel->getDeathType());
            $this->deathType = $cause->getCauseName();
            $this->deathDescription = $cause->getDescription();
            $this->deathImage = $cause->getImage();
    }

    function returnVars(){
        return get_object_vars($this);
    }

}