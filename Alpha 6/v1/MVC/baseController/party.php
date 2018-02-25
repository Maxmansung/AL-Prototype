<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/party_Interface.php");
class party implements party_Interface
{

    protected $partyID;
    protected $mapID;
    protected $members;
    protected $partyName;
    protected $pendingRequests;
    protected $pendingBans;
    protected $playersKnown;
    protected $overallZoneExploration;
    protected $tempBonus;

    public function __toString()
    {
        $output = $this->partyID;
        $output .= '/ '.$this->mapID;
        $output .= '/ '.$this->members;
        $output .= '/ '.$this->partyName;
        $output .= '/ '.$this->pendingRequests;
        $output .= '/ '.$this->pendingBans;
        $output .= '/ '.$this->playersKnown;
        $output .= '/ '.$this->overallZoneExploration;
        return $output;
    }

    function returnVars()
    {
        return get_object_vars($this);
    }


    function getPartyID()
    {
        return $this->partyID;
    }

    function setPartyID($var)
    {
        $this->partyID = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getMembers()
    {
        return $this->members;
    }

    function setMembers($var)
    {
        $this->members = $var;
    }

    function addMember($var)
    {
        array_push($this->members,$var);
        $this->members = array_values($this->members);
    }

    function removeMember($var)
    {
        $key = array_search($var,$this->members);
        unset($this->members[$key]);
        $this->members = array_values($this->members);
    }

    function getPendingRequests()
    {
        return $this->pendingRequests;
    }

    function setPendingRequests($var)
    {
        $this->pendingRequests = $var;
    }

    function addPendingRequests($var)
    {
        array_push($this->pendingRequests,$var);
        $this->pendingRequests = array_values($this->pendingRequests);
    }

    function removePendingRequests($var)
    {
        $key = array_search($var,$this->pendingRequests);
        unset($this->pendingRequests[$key]);
        $this->pendingRequests = array_values($this->pendingRequests);
    }

    function getPendingBans()
    {
        return $this->pendingBans;
    }

    function setPendingBans($var)
    {
        $this->pendingBans = $var;
    }

    function addPendingBans($var)
    {
        array_push($this->pendingBans,$var);
        $this->pendingBans = array_values($this->pendingBans);
    }

    function removePendingBans($var)
    {
        $key = array_search($var,$this->pendingBans);
        unset($this->pendingBans[$key]);
        $this->pendingBans = array_values($this->pendingBans);
    }

    function getPartyName()
    {
        return $this->partyName;
    }

    function setPartyName($var)
    {
        $this->partyName = $var;
    }

    function getPlayersKnown()
    {
        return $this->playersKnown;
    }

    function setPlayersKnown($var)
    {
        $this->playersKnown = $var;
    }

    function addPlayersKnown($var)
    {
        if (!in_array($var,$this->playersKnown)) {
            array_push($this->playersKnown, $var);
            $this->playersKnown = array_values($this->playersKnown);
        }
    }

    function removePlayersKnown($var)
    {
        foreach ($this->playersKnown as $key=>$player){
            if ($player == $var){
                unset($this->playersKnown[$key]);
            }
        }
        $this->playersKnown = array_values($this->playersKnown);
    }

    function getZoneExploration()
    {
        return $this->overallZoneExploration;
    }

    function setZoneExploration($var)
    {
        $this->overallZoneExploration = $var;
    }

    function addOverallZoneExploration($var,$biome,$depleted)
    {
        $varInt = intval($var);
        $this->overallZoneExploration[$varInt] = array($biome,$depleted);
    }

    function removeZoneExploration($var)
    {
        $varInt = intval($var);
        $this->overallZoneExploration[$varInt] = array("x","x");
    }

    function removeAllZoneExploration()
    {
        foreach ($this->overallZoneExploration as $key => $zone) {
            $this->overallZoneExploration[$key] = array("x","x");
        }
    }

    function getTempBonus(){
        return $this->tempBonus;
    }

    function setTempBonus($var){
        $this->tempBonus = $var;
    }

    function increaseTempBonus($var){
        $this->tempBonus += $var;
    }

    function combineZoneExploration($var){
        foreach ($var as $key=>$zone){
            if ($zone[0] != "x") {
                $this->addOverallZoneExplorationDetailed($key,$zone[0],$zone[1]);
                }
        }
    }

    function combinePlayersKnown($var){
        foreach ($var as $player){
            $this->addPlayersKnown($player);
        }
    }

    function addOverallZoneExplorationDetailed($var1,$biome,$depleted){
        $varInt = intval($var1);
        if ($this->overallZoneExploration[$varInt][0] == "x"){
            $this->overallZoneExploration[$varInt] = array($biome,$depleted);
        } else {
            if (intval($biome) < intval($this->overallZoneExploration[$varInt][0])) {
                $this->overallZoneExploration[$varInt] = array($biome, $depleted);
            }
            if (intval($biome) === intval($this->overallZoneExploration[$varInt][0])) {
                if ($depleted === 0) {
                    $this->overallZoneExploration[$varInt] = array($biome, $depleted);
                }
            }
        }
    }
}