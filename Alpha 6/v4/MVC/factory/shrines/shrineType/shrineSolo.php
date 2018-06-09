<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrineSolo extends shrineType
{

    function __construct()
    {
        $this->minPlayers = 1;
        $this->maxPlayers = 1;
        $this->typeName = "Cold Gods";
        $this->typeDescription = "These are the gods of the lone wolves, they favour those that refuse to team up and that go it alone. They may die fast but they burn bright.<br><br>Its a lonely life under these gods but perhaps that's for the best...";
    }

    function calculateShrineRankings($array)
    {
        $finalArray = [];
        foreach ($array as $player=>$count){
            $avatar = new avatarController($player);
            $finalArray[$avatar->getProfileID()] = $count;
        }
    }

    static function getCurrentRankings($map,$shrine,$knownList){
        $list = shrineActionsController::getMapTributes($map->getMapID(),$map->getCurrentDay());
        $votingArray = [];
        $sortingArray = [];
        foreach ($list as $action){
            if ($action->getShrineID() == $shrine->getShrineID()) {
                if (isset($votingArray[$action->getAvatar()])) {
                    $temp = $votingArray[$action->getAvatar()][0];
                } else {
                    $temp = 0;
                }
                $temp++;
                if (in_array($action->getAvatar(), $knownList) === true) {
                    $votingArray[$action->getAvatar()] = array($temp, $action->getProfileName());
                } else {
                    $votingArray[$action->getAvatar()] = array($temp, "Unknown");
                }
                $sortingArray[$action->getAvatar()] = $temp;
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
            if ($counter < shrineType::$soloCountedPlayers){
                array_push($avatarArray,$player[2]);
            }
        }
        return $avatarArray;
    }

    static function checkIfFavoured($rankingsList,$personalID){
        $count = 1;
        $check = false;
        foreach ($rankingsList as $player=>$array){
            if ($count <= shrineType::$soloCountedPlayers) {
                if ($array[2] === $personalID) {
                    $check = true;
                }
            }
            $count++;
        }
        return $check;
    }
}