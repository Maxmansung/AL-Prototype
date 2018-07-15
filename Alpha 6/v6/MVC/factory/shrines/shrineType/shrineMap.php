<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrineMap extends shrineType
{

    function __construct()
    {
        $this->minPlayers = 1;
        $this->maxPlayers = 100;
        $this->typeName = "Life Gods";
        $this->typeDescription = "Can you unite the whole land to work together? Only those that shun all other gods will gain their favour. If even one person goes against this the whole land will be shunned by them. <br><br>Either through kindness or force you will need to convince them all of your belief";
    }

    function calculateShrineRankings()
    {
        return "Null";
    }

    static function getCurrentRankings($map,$shrine){
        $list = shrineActionsController::getMapTributes($map->getMapID(),$map->getCurrentDay());
        $votingArray = [];
        $votingArray["check"] = true;
        $votingArray["shrine"] = $shrine->getShrineName();
        $votingArray['count'] = 0;
        foreach ($list as $action) {
            if ($action->getShrineType() !== $shrine->getShrineID()) {
                $votingArray["check"] = false;
            } else {
                $votingArray['count']++;
            }
        }
        return $votingArray;
    }

    static function getRewardedPlayers($rankingsArray){
        return self::checkIfFavoured($rankingsArray);
    }

    static function checkIfFavoured($rankingsList){
        if ($rankingsList['count'] > 0) {
            return $rankingsList['check'];
        } else {
            return false;
        }
    }
}