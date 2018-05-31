<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/deathScreen.php");
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
            $this->deathAchievements = $deathModel->deathAchievements;
            if (is_object($this->deathAchievements)) {
                $this->achievementDetails = achievementController::getAchievements($this->deathAchievements);
            }
            $this->gameType = $deathModel->gameType;
            $this->deathType = $deathModel->getDeathType();
            $this->dayDuration = $deathModel->dayDuration;
            $this->favourSolo = $deathModel->getFavourSolo();
            $this->favourTeam = $deathModel->getFavourTeam();
            $this->favourMap = $deathModel->getFavourMap();
        }
    }

    public static function createNewDeathScreen($avatar,$cause,$deathTemp,$nightTemp,$partyName,$map){
        $deathScreen = new deathScreenController("");
        $profile = new profileController($avatar->getProfileID());
        $deathScreen->setProfileID($profile->getProfileID());
        $deathScreen->setMapID($map->getName());
        $deathScreen->setPartyName($partyName);
        $deathScreen->setDeathDay($map->getCurrentDay());
        $deathScreen->setNightTemp($nightTemp);
        $deathScreen->setSurvivableTemp($deathTemp);
        $deathScreen->setDeathAchievements($avatar->getAchievements());
        $deathScreen->setGameType($map->getGameType());
        $deathScreen->setDeathType(intval($cause));
        $deathScreen->setDayDuration($map->getDayDuration());
        $deathScreen->setFavourSolo($avatar->getFavourSolo());
        $deathScreen->setFavourTeam($avatar->getFavourTeam());
        $deathScreen->setFavourMap($avatar->getFavourMap());
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

}