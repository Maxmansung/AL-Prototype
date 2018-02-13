<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/controller/deathScreen.php");
require_once(PROJECT_ROOT."/MVC/model/deathScreenModel.php");
class deathScreenController extends deathScreen
{
    protected $achievementDetails;

    public function __construct($profileID)
    {
        if ($profileID != ""){
            $deathModel = deathScreenModel::getDeathScreen($profileID);
            $this->profileID = $deathModel->profileID;
            $this->mapID = $deathModel->mapID;
            $this->partyName = $deathModel->partyName;
            $this->deathDay = $deathModel->deathDay;
            $this->nightTemp = $deathModel->nightTemp;
            $this->survivableTemp = $deathModel->survivableTemp;
            $this->deathStatistics = $deathModel->deathStatistics;
            $this->deathAchievements = $deathModel->deathAchievements;
            $this->achievementDetails = achievementController::getAchievements($this->deathAchievements);
            $this->gameType = $deathModel->gameType;
            $this->shrineScore = $deathModel->shrineScore;
            $this->shrineDisplay = buildingLevels::getShrineDetails($this->shrineScore);
            $this->deathType = $deathModel->getDeathType();
            $this->partyPlayersLeft = $deathModel->partyPlayersLeft;
        }
    }

    public static function createNewDeathScreen($avatarID,$deathTemp,$cause){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $party = new partyController($avatar->getPartyID());
        $deathScreen = new deathScreenController("");
        $deathScreen->setProfileID($avatar->getProfileID());
        $deathScreen->setMapID($map->getName());
        $deathScreen->setPartyName($party->getPartyName());
        $deathScreen->setDeathDay($map->getCurrentDay());
        $deathScreen->setNightTemp(intval($map->getBaseNightTemperature()));
        $deathScreen->setSurvivableTemp($deathTemp);
        $deathScreen->setDeathStatistics($avatar->getPlayStatistics());
        $deathScreen->setDeathAchievements($avatar->getAchievements());
        $deathScreen->setGameType($map->getGameType());
        $deathScreen->setShrineScore($avatar->getShrineScore());
        $deathScreen->setDeathType(intval($cause));
        $totalLeft = count($party->getMembers())-1;
        $deathScreen->setPartyPlayersLeft(intval($totalLeft));
        $deathScreen->insertDeathScreen();
    }

    public function insertDeathScreen(){
        deathScreenModel::insertDeathScreen($this,"Insert");
    }

    public function updateDeathScreen(){
        deathScreenModel::insertDeathScreen($this,"Update");
    }

    public function deleteDeathScreen(){
        deathScreenModel::deleteDeathScreen($this->profileID);
    }

    public function getShrineDetails(){
        $tempArray = [];
        foreach ($this->shrineScore as $key=>$value){
            $shrine = shrineController::createBlankShrine($key);
            $tempArray[$key] = $shrine->returnVars();
            $tempArray[$key]["score"] = $value;
        }
        $this->setShrineScore($tempArray);
    }

}