<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrineTeam extends shrineType
{

    function __construct()
    {
        $this->minPlayers = 2;
        $this->maxPlayers = 6;
        $this->typeName = "War Gods";
        $this->typeDescription = "These gods favour the waring tribes. Find a friend, make a base but don't get too strong. Together you can become more than the individual but beware of those around that might try to take what you have.<br><br>Battle those around to become the last tribe standing";
    }

    function calculateShrineRankings()
    {
        return "Null";
    }

    static function getCurrentRankings($map,$shrine){
        $list = shrineActionsController::getMapTributes($map->getMapID(),$map->getCurrentDay());
        $votingArray = [];
        $sortingArray = [];
        foreach ($list as $action){
            if ($action->getShrineID() == $shrine->getShrineID()) {
                if (isset($votingArray[$action->getPartyID()])){
                    $temp = $votingArray[$action->getPartyID()];
                } else {
                    $temp = 0;
                }
                $temp++;
                $votingArray[$action->getPartyID()] = array(($temp+1),$action->getPartyName());
                $sortingArray[$action->getPartyID()] = $temp;
            }
        }
        arsort($sortingArray);
        $realFinal = [];
        $counter = 0;
        foreach ($sortingArray as $key=>$item){
            $tempArray = $votingArray[$key];
            array_push($tempArray,$key);
            $realFinal[$counter] = $tempArray;
            $counter++;
        }
        return $realFinal;
    }

    static function getRewardedPlayers($rankingsArray){
        $counter = 1;
        $avatarArray = [];
        foreach ($rankingsArray as $player){
            if ($counter <= shrineType::$teamCountedPlayers){
                array_push($avatarArray,$player[2]);
            }
        }
        return $avatarArray;
    }

    static function checkIfFavoured($rankingsList,$partyID){
        $count = 1;
        $check = false;
        foreach ($rankingsList as $array){
            if ($count <= shrineType::$teamCountedPlayers) {
                if ($array[2] === $partyID) {
                    $check = true;
                }
            }
            $count++;
        }
        return $check;
    }
}