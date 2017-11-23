<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/interface/avatar_Interface.php");
class avatar implements avatar_Interface
{

    protected $avatarID = "";
    protected $profileID = "";
    protected $mapID = "";
    protected $stamina = 0;
    protected $maxStamina = 0;
    protected $zoneID = "";
    protected $inventory = array();
    protected $maxInventorySlots = 0;
    protected $partyID = "";
    protected $readiness = false;
    protected $avatarTempRecord = [];
    protected $avatarSurvivableTemp = 0;
    protected $achievements = array();
    protected $partyVote = array();
    protected $researchStats = array();
    protected $researched = array();
    protected $playStatistics = array();
    protected $tempModLevel = 0;
    protected $findingChanceMod = 0;
    protected $findingChanceFail = 0;
    protected $shrineScore = [];

    public function __toString()
    {
        $output = $this->avatarID;
        $output .= '/ '.$this->profileID;
        $output .= '/ '.$this->mapID;
        $output .= '/ '.$this->stamina;
        $output .= '/ '.$this->maxStamina;
        $output .= '/ '.$this->zoneID;
        $output .= '/ '.$this->inventory;
        $output .= '/ '.$this->maxInventorySlots;
        $output .= '/ '.$this->partyID;
        $output .= '/ '.$this->readiness;
        $output .= '/ '.$this->avatarTempRecord;
        $output .= '/ '.$this->avatarSurvivableTemp;
        $output .= '/ '.$this->partyVote;
        $output .= '/ '.$this->researched;
        $output .= '/ '.$this->playStatistics;
        $output .= '/ '.$this->tempModLevel;
        $output .= '/ '.$this->shrineScore;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getAvatarID()
    {
        return $this->avatarID;
    }

    function setAvatarID($var)
    {
        $this->avatarID = $var;
    }

    function getProfileID()
    {
        return $this->profileID;
    }

    function setProfileID($var)
    {
        $this->profileID = $var;
    }

    function getMapID()
    {
        return $this->mapID;
    }

    function setMapID($var)
    {
        $this->mapID = $var;
    }

    function getStamina()
    {
        return $this->stamina;
    }

    function setStamina($var)
    {
        $this->stamina = $var;
    }

    function getMaxStamina()
    {
        return $this->maxStamina;
    }

    function setMaxStamina($var)
    {
        $this->maxStamina = $var;
    }

    function getZoneID()
    {
        return $this->zoneID;
    }

    function setZoneID($var)
    {
        $this->zoneID = $var;
    }

    function getInventory()
    {
        return $this->inventory;
    }

    function setInventory($var)
    {
        $this->inventory = $var;
    }

    function addInventoryItem($var)
    {
        if (!in_array($var,$this->inventory)) {
            array_push($this->inventory, $var);
            $this->inventory = array_values($this->inventory);
        }
    }

    function removeInventoryItem($var)
    {
        if (in_array($var,$this->inventory)) {
            $key = array_search($var, $this->inventory);
            unset($this->inventory[$key]);
            $this->inventory = array_values($this->inventory);
        }
    }

    function getMaxInventorySlots()
    {
        return $this->maxInventorySlots;
    }

    function setMaxInventorySlots($var)
    {
        $this->maxInventorySlots = $var;
    }

    function getPartyID()
    {
        return $this->partyID;
    }

    function setPartyID($var)
    {
        $this->partyID = $var;
    }

    function getReady()
    {
        return $this->readiness;
    }

    function toggleReady($var)
    {
        if ($var === "ready"){
           if ($this->readiness == true){
               $this->readiness = false;
           }
           else{
               $this->readiness = true;
           }
        }
        if ($var === "dead"){
            $this->readiness = "dead";
        }
    }

    function getavatarTempRecord()
    {
        return $this->avatarTempRecord;
    }

    function setavatarTempRecord($var)
    {
        $this->avatarTempRecord = $var;
    }

    function getAvatarSurvivableTemp()
    {
        return $this->avatarSurvivableTemp;
    }

    function setAvatarSurvivableTemp($var)
    {
        $this->avatarSurvivableTemp = $var;
    }

    function getAchievements()
    {
        return $this->achievements;
    }

    function setAchievements($var)
    {
        $this->achievements = $var;
    }

    function addAchievement($var)
    {
        if ($this->achievements == ""){
            $this->achievements = array();
        }
        $this->achievements = $this->achievements + array($var=>1);
    }

    function removeAchievement($var)
    {
        $this->achievements = array_diff($this->achievements,array($var));
    }

    function addPartyVotePlayer($var)
    {
        $this->partyVote[$var] = 0;
    }

    function removePartyVotePlayer($var)
    {
        unset($this->partyVote[$var]);
    }

    function changePartyVote($var, $vote)
    {
        $vote = intval($vote);
        $this->partyVote[$var] = $vote;
    }

    function clearVotes()
    {
        foreach ($this->partyVote as $key=>$vote){
            $this->partyVote[$key] = 0;
        }
    }

    function getPartyVote()
    {
        return $this->partyVote;
    }

    function getResearchStats()
    {
        return $this->researchStats;
    }

    function setResearchStats($type, $var)
    {
        $this->researchStats[$type] = intval($var);
    }

    function getResearchStatsLevel(){
        return intval($this->researchStats[0]);
    }

    function getResearchStatsStamina(){
        return intval($this->researchStats[1]);
    }

    function adjustResearchStatsLevel($var){
        $temp = intval($this->researchStats[0]);
        $temp += $var;
        $this->researchStats[0] = $temp;
    }

    function adjustResearchStatsStamina($var){
        $temp = intval($this->researchStats[1]);
        $temp += $var;
        $this->researchStats[1] = $temp;
    }

    function getResearched()
    {
        return $this->researched;
    }

    function setResearched($var)
    {
        $this->researched = $var;
    }

    function addResearched($var)
    {
        if (!in_array($var,$this->researched)){
            array_push($this->researched,$var);
        }
    }

    function removeResearched($var)
    {
        foreach ($this->researched as $key=>$building){
            if ($building == $var){
                unset($this->researched[$key]);
            }
        }
    }

    function getPlayStatistics()
    {
        return $this->playStatistics;
    }

    function setPlayStatistics($var)
    {
        $this->playStatistics = $var;
    }

    function addPlayStatistics($var, $count)
    {
       if (!empty($this->playStatistics[$var])){
           $this->playStatistics[$var] = intval($this->playStatistics[$var])+$count;
       } else {
           $this->playStatistics[$var] = $count;
       }
    }

    function removePlayStatistics($var, $count)
    {
        if (!empty($this->playStatistics[$var])){
            $this->playStatistics[$var] = intval($this->playStatistics[$var])-$count;
        } else {
            $this->playStatistics[$var] = 0;
        }
    }

    function getTempModLevel()
    {
        return $this->tempModLevel;
    }

    function setTempModLevel($var)
    {
        $this->tempModLevel = $var;
    }

    function addAvatarTempRecord($day, $var)
    {
        if(!key_exists($day,$this->avatarTempRecord)) {
            $this->avatarTempRecord[$day] = $var;
        }
    }

    function getSingleAvatarTempRecord($day)
    {
        return $this->avatarTempRecord[$day];
    }

    function getFindingChanceMod()
    {
        return $this->findingChanceMod;
    }

    function setFindingChanceMod($var)
    {
        $this->findingChanceMod = $var;
    }

    function getFindingChanceFail()
    {
        return $this->findingChanceFail;
    }

    function setFindingChanceFail($var)
    {
        $this->findingChanceFail = $var;
    }

    function increaseFindingChanceFail($var)
    {
        $this->findingChanceFail += $var;
    }

    function resetFindingChanceFail()
    {
        $this->findingChanceFail = $this->findingChanceMod;
    }

    function getShrineScore()
    {
        return $this->shrineScore;
    }

    function setShrineScore($var)
    {
        $this->shrineScore = $var;
    }

    function addShineScore($shine, $day)
    {
        if (key_exists($shine,$this->shrineScore)){
            $current = intval($this->shrineScore[$shine]);
            $this->shrineScore[$shine] = $current + intval($day);
        } else {
            $this->shrineScore[$shine] = $day;
        }
    }
}