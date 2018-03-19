<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/profile_Interface.php");
class profile implements profile_Interface
{
    protected $profileID = "";
    protected $password = "";
    protected $profilePicture = "";
    protected $email = "";
    protected $lastlogin = "";
    protected $loginIP = "";
    protected $accountType = "";
    protected $gameStatus = "";
    protected $avatarID = "";
    protected $achievements = array();
    protected $achievementsSolo = array();
    protected $bio = "";
    protected $country = "";
    protected $gender = "";
    protected $age = "";
    protected $playStatistics = array();
    protected $uploadSecurity = null;
    protected $passwordRecovery;
    protected $passwordRecoveryTimer;
    protected $cookieKey;
    protected $shrineScore;
    protected $forumPosts;

    public function __toString()
    {
        $output = $this->profileID;
        $output .= '/ '.$this->password;
        $output .= '/ '.$this->profilePicture;
        $output .= '/ '.$this->email;
        $output .= '/ '.$this->lastlogin;
        $output .= '/ '.$this->loginIP;
        $output .= '/ '.$this->accountType;
        $output .= '/ '.$this->gameStatus;
        $output .= '/ '.$this->avatarID;
        $output .= '/ '.$this->achievements;
        $output .= '/ '.$this->achievementsSolo;
        $output .= '/ '.$this->bio;
        $output .= '/ '.$this->country;
        $output .= '/ '.$this->gender;
        $output .= '/ '.$this->age;
        $output .= '/ '.$this->playStatistics;
        $output .= '/ '.$this->uploadSecurity;
        $output .= '/ '.$this->passwordRecovery;
        $output .= '/ '.$this->passwordRecoveryTimer;
        $output .= '/ '.$this->cookieKey;
        $output .= '/ '.$this->shrineScore;
        $output .= '/ '.$this->forumPosts;
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

    function getPassword()
    {
        return $this->password;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function getProfilePicture()
    {
        return $this->profilePicture;
    }

    function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function getLastLogin()
    {
        return $this->lastlogin;
    }

    function setLastLogin($lastLogin)
    {
        $this->lastlogin = $lastLogin;
    }

    function getLoginIP()
    {
        return $this->loginIP;
    }

    function setLoginIP($loginIP)
    {
        $this->loginIP = $loginIP;
    }

    function getAccountType()
    {
        return $this->accountType;
    }

    function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    function getGameStatus()
    {
        return $this->gameStatus;
    }

    function setGameStatus($gameStatus)
    {
        if ($gameStatus == "in") {
            $this->gameStatus = "in";
        } elseif ($gameStatus == "death"){
            $this->gameStatus = "death";
        } else {
            $this->gameStatus = "ready";
        }
    }

    function getAvatar()
    {
        return $this->avatarID;
    }

    function setAvatar($avatar)
    {
        $this->avatarID = $avatar;
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

    function getUploadSecurity()
    {
        return $this->uploadSecurity;
    }

    function setUploadSecurity()
    {
        $this->uploadSecurity = time();
    }

    function getPasswordRecovery()
    {
        return $this->passwordRecovery;
    }

    function setPasswordRecovery()
    {
        $salt = data::$salt["salt2"];
        $password = crypt(time(),"$6$".$salt);
        $password =  preg_replace('#[^a-z0-9]#i', '', $password);
        $password = substr($password,0,20);
        $this->passwordRecovery = $password;
    }

    function getPasswordRecoveryTimer()
    {
        return $this->passwordRecoveryTimer;
    }

    function setPasswordRecoveryTimer()
    {
        $this->passwordRecoveryTimer = time();
    }

    function resetPasswordRecovery(){}

    function getCookieKey()
    {
        return $this->cookieKey;
    }

    function setCookieKey()
    {
        $this->cookieKey = data::keyGenerator();
    }

    function getShrineScore()
    {
        return $this->shrineScore;
    }

    function setShrineScore($var)
    {
        $this->shrineScore = $var;
    }

    function addShrineScores($var)
    {
        foreach ($var as $key=>$value){
            $exists = false;
            foreach ($this->shrineScore as $profileKey=>$profileScore){
                if ($profileKey == $key){
                    $this->shrineScore[$key]+=intval($value);
                    $exists = true;
                }
            }
            if ($exists === false){
                $this->shrineScore[$key]=intval($value);
            }
        }
    }

    function getTotalFavour(){
        $score = 0;
        foreach ($this->shrineScore as $value){
            $score += $value;
        }
        return $score;
    }

    function getForumPosts()
    {
        return $this->forumPosts;
    }

    function setForumPosts($var)
    {
        $this->forumPosts = $var;
    }

    function addForumPosts($var)
    {
        if (is_array($this->forumPosts)) {
            if (!in_array($var, $this->forumPosts)) {
                array_push($this->forumPosts, $var);
            }
        } else {
            $temp = [$this->forumPosts];
            array_push($temp, $var);
            $this->forumPosts = $temp;
        }
    }

    function removeForumPosts($var)
    {
        $index = array_search($var, $this->forumPosts);
        if ( $index !== false ) {
            unset( $this->forumPosts[$index]);
            $this->forumPosts = array_values($this->forumPosts);
        }
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
}