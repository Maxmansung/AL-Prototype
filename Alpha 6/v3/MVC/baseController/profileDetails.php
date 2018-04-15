<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/profileDetails_Interface.php");
class profileDetails implements profileDetails_Interface
{
    protected $profileID;
    protected $age;
    protected $gender;
    protected $keyAchievement1;
    protected $keyAchievement2;
    protected $keyAchievement3;
    protected $keyAchievement4;
    protected $favouriteGod;
    protected $country;
    protected $bio;
    protected $achievements;
    protected $achievementsSolo;
    protected $uploadSecurity;
    protected $mainGames;
    protected $speedGames;
    protected $soloLeaderboard;
    protected $teamLeaderboard;
    protected $fullLeaderboard;

    public function __toString()
    {
        $output = $this->profileID;
        $output .= '/ '.$this->achievements;
        $output .= '/ '.$this->achievementsSolo;
        $output .= '/ '.$this->bio;
        $output .= '/ '.$this->country;
        $output .= '/ '.$this->gender;
        $output .= '/ '.$this->age;
        $output .= '/ '.$this->uploadSecurity;
        $output .= '/ '.$this->keyAchievement1;
        $output .= '/ '.$this->keyAchievement2;
        $output .= '/ '.$this->keyAchievement3;
        $output .= '/ '.$this->keyAchievement4;
        $output .= '/ '.$this->favouriteGod;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getProfileID()
    {
        return $this->profileID;
    }

    function setProfileID($profileID)
    {
        $this->profileID = $profileID;
    }

    function getAchievements()
    {
        return $this->achievements;
    }

    function setAchievements($achievements)
    {
        $this->achievements = $achievements;
    }

    function addAchievements($avatarAchievements)
    {
        foreach ($avatarAchievements as $avatarKey=>$avatarAchieve){
            $exists = false;
            foreach ($this->achievements as $profileKey=>$profileAchieve){
                if ($profileKey == $avatarKey){
                    $this->achievements[$profileKey]+=$avatarAchieve;
                    $exists = true;
                }
            }
            if ($exists === false){
                $this->achievements[$avatarKey]=$avatarAchieve;
            }
        }
    }

    function getBio()
    {
        return $this->bio;
    }

    function setBio($var)
    {
        $this->bio = $var;
    }

    function getCountry()
    {
        return $this->country;
    }

    function setCountry($var)
    {
        $this->country = $var;
    }

    function getGender()
    {
        return $this->gender;
    }

    function setGender($var)
    {
        $this->gender = $var;
    }

    function getAge()
    {
        return $this->age;
    }

    function setAge($var)
    {
        $this->age = $var;
    }

    function getUploadSecurity()
    {
        return $this->uploadSecurity;
    }

    function setUploadSecurity()
    {
        $this->uploadSecurity = time();
    }

    function getAchievementsSolo()
    {
        return $this->achievementsSolo;
    }

    function setAchievementsSolo($achievements)
    {
        $this->achievementsSolo = $achievements;
    }

    function addAchievementsSolo($achievements)
    {
        foreach ($achievements as $avatarKey=>$avatarAchieve){
            $exists = false;
            foreach ($this->achievementsSolo as $profileKey=>$profileAchieve){
                if ($profileKey == $avatarKey){
                    $this->achievementsSolo[$profileKey]+=$avatarAchieve;
                    $exists = true;
                }
            }
            if ($exists === false){
                $this->achievementsSolo[$avatarKey]=$avatarAchieve;
            }
        }
    }

    function getKeyAchievement1()
    {
        return $this->keyAchievement1;
    }

    function setKeyAchievement1($var)
    {
        $this->keyAchievement1 = $var;
    }

    function getKeyAchievement2()
    {
        return $this->keyAchievement2;
    }

    function setKeyAchievement2($var)
    {
        $this->keyAchievement2 = $var;
    }

    function getKeyAchievement3()
    {
        return $this->keyAchievement3;
    }

    function setKeyAchievement3($var)
    {
        $this->keyAchievement3 = $var;
    }

    function getKeyAchievement4()
    {
        return $this->keyAchievement4;
    }

    function setKeyAchievement4($var)
    {
        $this->keyAchievement4 = $var;
    }

    function getFavouriteGod()
    {
        return $this->favouriteGod;
    }

    function setFavouriteGod($var)
    {
        $this->favouriteGod = $var;
    }

    function getMainGames()
    {
        return $this->mainGames;
    }

    function setMainGames($var)
    {
        $this->mainGames = $var;
    }

    function increaseMainGames()
    {
        $this->mainGames += 1;
    }

    function getSpeedGames()
    {
        return $this->speedGames;
    }

    function setSpeedGames($var)
    {
        $this->speedGames = $var;
    }

    function increaseSpeedGames()
    {
        $this->speedGames += 1;
    }

    function getSoloLeaderboard()
    {
        return $this->soloLeaderboard;
    }

    function setSoloLeaderboard($var)
    {
        $this->soloLeaderboard = $var;
    }

    function getTeamLeaderboard()
    {
        return $this->teamLeaderboard;
    }

    function setTeamLeaderboard($var)
    {
        $this->teamLeaderboard = $var;
    }

    function getFullLeaderboard()
    {
        return $this->fullLeaderboard;
    }

    function setFullLeaderboard($var)
    {
        $this->fullLeaderboard = $var;
    }
}