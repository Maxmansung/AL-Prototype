<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class joinGameView
{

    protected $mapID;
    protected $mapType;
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
        if ($mapController->getGameType() == "Tutorial") {
            $this->mapType = 1;
        } else if ($mapController->getGameType() == "Main") {
            $this->mapType = 2;
        } else {
            $this->mapType = 3;
        }
        $this->mapName = $mapController->getName();
        $this->maxPlayers = $mapController->getMaxPlayerCount();
        $this->currentPlayers = count($mapController->getAvatars());
        $this->mapSize = $mapController->getEdgeSize();
        if ($mapController->getDayDuration() === "check") {
            $this->gameType = 2;
        } else {
            $this->gameType = 1;
        }
    }

    static protected function createMapList($profileAccess)
    {
        $tempList = [];
        if ($profileAccess <= 5){
            $mapList = mapController::joingames();
            $counter = 0;
            foreach ($mapList as $map) {
                $temp = false;
                if ($map->getCurrentDay() === 1) {
                    if ($map->getMaxPlayerCount() > count($map->getAvatars())) {
                        if ($profileAccess === 5) {
                            if ($map->getGameType() === "Tutorial") {
                                $temp = new joinGameView($map);
                            }
                        } else if ($profileAccess === 4) {
                            if ($map->getGameType() != "Test") {
                                $temp = new joinGameView($map);
                            }
                        } else if ($profileAccess <= 3) {
                            $temp = new joinGameView($map);
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

    static function createView($profileAccess){
        $maps = joinGameView::createMapList($profileAccess);
        $news = newsStoryController::getAllVisibleNews();
        $temp = array("NEWS"=>$news,"MAPS"=>$maps);
        return $temp;
    }
}