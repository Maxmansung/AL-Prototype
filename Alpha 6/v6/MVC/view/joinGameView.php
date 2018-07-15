<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class joinGameView
{

    protected $mapID;
    protected $mapSpeed;
    protected $mapName;
    protected $maxPlayers;
    protected $currentPlayers;
    protected $mapSize;
    protected $gameType;

    protected function returnVars()
    {
        return get_object_vars($this);
    }

    function __construct($mapController)
    {
        $this->mapID = $mapController->getMapID();
        $this->gameType = $mapController->getGameType();
        $this->mapName = $mapController->getName();
        $this->maxPlayers = $mapController->getMaxPlayerCount();
        $this->currentPlayers = count($mapController->getAvatars());
        $this->mapSize = $mapController->getEdgeSize();
        if ($mapController->getDayDuration() === "check") {
            $this->mapSpeed = 2;
        } else {
            $this->mapSpeed = 1;
        }
    }

    static protected function createMapList($profile)
    {
        $tempList = [];
        if ($profile->getAccessActivated()===1){
            $mapList = mapController::joingames(false);
            $counter = 0;
            foreach ($mapList as $map) {
                $temp = false;
                if ($map->getCurrentDay() === 1) {
                    if ($map->getMaxPlayerCount() > count($map->getAvatars())) {
                        if ($profile->getAccessAllGames() === 1) {
                            if ($map->getGameType() !== 4) {
                                $temp = new joinGameView($map);
                            }
                        } else {
                            if ($map->getGameType() === 3) {
                                $temp = new joinGameView($map);
                            }
                        }
                    }
                }
                if ($temp != false){
                    $tempList[$counter] = $temp->returnVars();
                    $counter++;
                }
            }
        }
        return $tempList;
    }

    static function createView($profile){
        $profile->getProfileAccess();
        $maps = joinGameView::createMapList($profile);
        $news = newsStoryController::getAllVisibleNews();
        $temp = array("NEWS"=>$news,"MAPS"=>$maps);
        return $temp;
    }
}