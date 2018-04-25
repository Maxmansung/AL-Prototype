<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
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
            if ($profile->getAccessEditMap()===1){
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
        $profile->getProfileAccess();
        if ($profile->getAccessActivated()===1) {
            foreach ($mapArray as $map) {
                if ($map->getGameType() == "Test" || $map->getGameType() == "Main") {
                    if ($profile->getAccessAllGames()===1) {
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
        $avatars = avatarController::getAllMapAvatars($mapID,false);
        $counter = 0;
        foreach ($avatars as $player){
            if ($player->getReady() != "dead"){
                $counter++;
            }
        }
        return $counter;
    }

    public static function editPlayerStats($avatarID, $stamina, $heatBonus, $profile){
        $profile->getProfileAccess();
        if ($profile->getAccessEditMap()===1) {
            $avatarIDClean = intval(preg_replace('#[^0-9]#i', '', $avatarID));
            $avatar = new avatarController($avatarIDClean);
            if ($avatar->getAvatarID() === $avatarIDClean) {
                $staminaClean = intval(preg_replace('#[^0-9]#i', '', $stamina));
                $heatBonusClean = intval(preg_replace('#[^0-9]#i', '', $heatBonus));
                if ($staminaClean != $stamina || $heatBonusClean != $heatBonus){
                    return array("ERROR"=>136);
                } else {
                    modTrackingController::createNewTrack(8,$profile->getProfileID(),$staminaClean,$avatar->getStamina(),$heatBonusClean,$avatar->getAvatarSurvivableTemp());
                    $avatar->setStamina($staminaClean);
                    $avatar->setAvatarSurvivableTemp($heatBonusClean);
                    $avatar->updateAvatar();
                    return array("ALERT"=>25,"DATA"=>$avatar->getProfileID());
                }
            } else {
                return array("ERROR"=>"This avatar does not exist");
            }
        } else {
            return array("ERROR"=>28);
        }
    }

    public static function editMapStats($profile, $mapID, $maxPlayers, $nightTemp){
        $profile->getProfileAccess();
        if ($profile->getAccessEditMap()===1){
            $mapIDClean = intval(preg_replace('#[^0-9]#i', '', $mapID));
            $map = new mapController($mapIDClean);
            if ($map->getMapID() === $mapIDClean){
                $maxPlayersClean = intval(preg_replace('#[^0-9]#i', '', $maxPlayers));
                $nightTempClean = intval(preg_replace('#[^0-9]#i', '', $nightTemp));
                if ($maxPlayersClean != $maxPlayers || $nightTempClean != $nightTemp){
                    return array("ERROR"=>136);
                } else {
                    if (count($map->getAvatars())>$maxPlayersClean){
                        $maxPlayersClean = count($map->getAvatars());
                    }
                    modTrackingController::createNewTrack(6,$profile->getProfileID(),$maxPlayersClean,$map->getMaxPlayerCount(),$nightTempClean,$map->getBaseNightTemperature());
                    $map->setMaxPlayerCount($maxPlayersClean);
                    $map->setBaseNightTemperature($nightTempClean);
                    $map->updateMap();
                    return array("ALERT"=>27,"DATA"=>$map->getName());
                }
            } else {
                return array("ERROR"=>"This map does not exist");
            }
        } else{
            return array("ERROR"=>28);
        }
    }
}