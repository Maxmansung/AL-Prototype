<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class diaryView
{

    protected $logs;
    protected $day;
    protected $personalTemp;
    protected $nightTemp;
    protected $currentDay;
    protected $shrines;
    protected $messagesSent;
    protected $messagesReceived;

    function __construct($avatarID,$day)
    {
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $this->logs = chatlogAllController::getAllLogs($avatarID,$day);
        $this->currentDay = $map->getCurrentDay();
        if ($day === "current" || $day == $map->getCurrentDay()) {
            $this->day = intval($map->getCurrentDay());
            $this->nightTemp = $map->getBaseNightTemperature();
            $this->personalTemp = buildingLevels::getTotalSurviveTemp($avatarID);
            $this->shrines = shrineController::getMapScores($map->getMapID(),false);
        } else {
            $this->nightTemp = $map->getSingleTemperatureRecord($day);
            $this->personalTemp = $avatar->getSingleAvatarTempRecord($day);
            $this->shrines = shrineController::getOldMapScores($map->getMapID(),$day);
            $this->day = $day;
        }
        $this->messagesReceived = privateMessagesController::getAllReceived($avatarID,"view");
        $this->messagesSent = privateMessagesController::getAllSent($avatarID,"view");
    }

    function returnVars(){
        return get_object_vars($this);
    }
}