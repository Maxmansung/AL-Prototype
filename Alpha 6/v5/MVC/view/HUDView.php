<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class HUDView
{
    protected $mapDay;
    protected $mapName;
    protected $mapTimer;
    protected $dayEndStat;
    protected $readyStat;
    protected $playerStatus;
    protected $staminaCurrent;
    protected $staminaMax;
    protected $playerTemp;
    protected $nightTemp;

    function returnVars(){
        return get_object_vars($this);
    }

    static function createView($profile){
        $avatarController = new avatarController($profile->getAvatar());
        $mapController = new mapController($avatarController->getMapID());
        $view = new HUDView($avatarController,$mapController);
        return $view->returnVars();
    }

    function __construct($avatarController, $mapController)
    {
        $this->mapDay = $mapController->getCurrentDay();
        $this->mapName = $mapController->getName();
        $this->mapTimer = date("G:i",time());
        if ($mapController->getDayDuration() == "full"){
            $this->createTimer();
            $this->readyStat = "ERROR";
        } else {
            $this->dayEndStat = "ERROR";
            $this->readyStat = $avatarController->getReady();
        }
        $this->createStatusArray($avatarController->getStatusArray());
        $this->staminaCurrent = $avatarController->getStamina();
        $this->staminaMax = $avatarController->getMaxStamina();
        $zoneController = new zoneController($avatarController->getZoneID());
        $biome = "biome".$zoneController->getBiomeType();
        $biomeController = new $biome();
        $partyController = new partyController($avatarController->getPartyID());
        $this->playerTemp = buildingLevels::getTotalSurviveTemp($avatarController,$zoneController,$biomeController,$partyController,true);
        $this->nightTemp = buildingLevels::totalNightTemp($mapController,$biomeController,true);
    }

    private function createStatusArray($array){
        $finalArray = [];
        foreach ($array as $key=>$true){
            if ($true == 1){
                $className = "status".$key;
                $status = new $className();
                $finalArray[$status->getStatusID()] = $status->returnViewVars();
            }
        }
        $this->playerStatus = $finalArray;
    }

    private function createTimer()
    {
        $time = time();
        $endTime = strtotime("today 11:00pm");
        $timeUntil = $endTime - $time;
        if ($timeUntil <= 0) {
            $this->dayEndStat = "Tomorrow";
        } else if ($timeUntil > 0 && $timeUntil < 3601) {
            $minutes = ceil($timeUntil / 60);
            if ($minutes > 1) {
                $this->dayEndStat = "~" . $minutes . " mins";
            } else {
                $this->dayEndStat = "~" . $minutes . " minute";
            }
        } else {
            $hours = floor($timeUntil / 3600);
            if ($hours > 1) {
                $this->dayEndStat = "~" . $hours . " hours";
            } else {
                $this->dayEndStat = "~" . $hours . " hour";
            }
        }
    }

}