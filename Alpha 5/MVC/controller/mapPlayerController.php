<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class mapPlayerController
{


    protected $mapName;
    protected $maxPlayers;
    protected $alivePlayers;
    protected $currentPlayers;
    protected $currentPlayersCount;
    protected $mapSize;
    protected $maxStamina;
    protected $currentDay;
    protected $playAble;
    protected $mapID;
    protected $dayLength;
    protected $gameType;

    private function __construct($mapController,$profile)
    {
        $this->currentDay = $mapController->getCurrentDay();
        $this->maxPlayers = $mapController->getMaxPlayerCount();
        $this->currentPlayersCount = count($mapController->getAvatars());
        $this->mapID = $mapController->getMapID();
        $this->alivePlayers = self::getDeadPlayers($mapController->getMapid());
        if ($this->currentDay>1 || $this->currentPlayersCount>= $this->maxPlayers || in_array($mapController->getMapID().$profile->getProfileID(),$mapController->getAvatars())){
            if ($profile->getAccountType() === "admin" || $profile->getAccountType() === "mod"){
                $this->mapName = $mapController->getName();
                $this->currentPlayers = $mapController->getAvatars();
                $this->mapSize = $mapController->getEdgeSize();
                $this->maxStamina = $mapController->getMaxPlayerStamina();
                $this->dayLength = $mapController->getDayDuration();
                $this->gameType = $mapController->getGameType();
            }
            $this->playAble = false;
        } else {
            $this->mapName = $mapController->getName();
            $this->currentPlayers = $mapController->getAvatars();
            $this->mapSize = $mapController->getEdgeSize();
            $this->maxStamina = $mapController->getMaxPlayerStamina();
            $this->dayLength = $mapController->getDayDuration();
            $this->gameType = $mapController->getGameType();
            $this->playAble = true;
        }
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function getAllMaps($profile){
        $mapArray = mapController::joingames();
        $counter = 0;
        $finalArray = [];
        if ($profile->getAccountType() != "disabled" && $profile->getAccountType() != "new") {
            foreach ($mapArray as $map) {
                if ($map->getGameType() == "Test" || $map->getGameType() == "Main") {
                    if ($profile->getAccountType() == "admin" || $profile->getAccountType() == "mod" || $profile->getAccountType() == "active") {
                        $tempObject = new mapPlayerController($map, $profile);
                        $finalArray[$counter] = $tempObject->returnVars();
                        $counter++;
                    }
                } else {
                    $tempObject = new mapPlayerController($map, $profile);
                    $finalArray[$counter] = $tempObject->returnVars();
                    $counter++;
                }
            }
        }
        return array("maps"=>$finalArray,"profileName"=>$profile->getProfileID(),"access"=>$profile->getAccountType());
    }

    private static function getDeadPlayers($mapID){
        $avatars = avatarController::getAllMapAvatars($mapID);
        $counter = 0;
        foreach ($avatars as $player){
            if ($player->getReady() != "dead"){
                $counter++;
            }
        }
        return $counter;
    }
}