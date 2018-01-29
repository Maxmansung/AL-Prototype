<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/model/profileTitlesModel.php");
class profileAchievementController
{

    protected $profileID;
    protected $profilePicture;
    protected $lastlogin;
    protected $accountType;
    protected $gameStatus;
    protected $avatarID;
    protected $achievements;
    protected $bio;
    protected $isPlayer;
    protected $profileScore;
    protected $country;
    protected $gender;
    protected $age;
    protected $profileLevel;
    protected $playStatistics;
    protected $profileTitle;
    protected $favourScore;
    protected $shrinesDetail;

    function getProfileScore(){
        return $this->profileScore;
    }


    function returnVars(){
        return get_object_vars($this);
    }

    public static function newController($profileID,$playerID){
        $profile = new profileController($profileID);
        if ($profile->getProfileID() !== null) {
            $return = new profileAchievementController($profile,$playerID);
            return $return->returnVars();
        }
        else {
            return array("ERROR"=>37);
        }
    }

    public static function editProfileController($playerID){
        $profile = new profileController($playerID);
        if ($profile->getProfileID() !== null) {
            $return = new profileAchievementController($profile,$playerID);
            return $return->returnVars();
        }
        else {
            return array("ERROR"=>37);
        }

    }

    public function __construct($profile,$playerID)
    {
        $this->profileID = $profile->getProfileID();
        $this->profilePicture = $profile->getProfilePicture();
        $date = $profile->getLastLogin();
        $createDate = new DateTime($date);
        $this->lastlogin = $createDate->format('j M y');
        $this->accountType = $profile->getAccountType();
        $this->gameStatus = $profile->getGameStatus();
        $this->avatarID = $profile->getAvatar();
        $achievementDetails = $this->getAchievements($profile->getAchievements());
        $this->achievements = $achievementDetails[0];
        $this->profileScore = round($achievementDetails[1]);
        $this->bio = $profile->getBio();
        $this->country = $profile->getCountry();
        $this->gender = $profile->getGender();
        $this->age = $profile->getAge();
        $this->playStatistics = $profile->getPlayStatistics();
        $this->profileTitle = profileTitles::calculateTitle($this->playStatistics);
        if ($profile->getProfileID() === $playerID){
            $this->isPlayer = true;
        } else {
            $this->isPlayer = false;
        }
        $this->profileLevel = self::getProfileLevel($this->profileScore);
        $this->shrinesDetail = buildingLevels::getShrineDetails($profile->getShrineScore());
        $this->favourScore = $profile->getTotalFavour();
    }

    private function getAchievements($achievementList)
    {
        $achievementArray = [];
        $totalScore = 0;
        foreach ($achievementList as $key => $count) {
            $achievement = new achievementController($key);
            $achievementArray[$achievement->getAchievementID()] = ["details"=>$achievement->returnVars(),"count"=>$count];
            $totalScore+=(($achievement->getScoreAdjustment()*$count)/10);
        }
        return array($achievementArray,$totalScore);
    }

    public static function updateProfile($bio,$age,$gender,$country,$picture,$profileID){
        $profile = new profileController($profileID);
        if ($bio !== ""){
            $profile->setBio($bio);
        }
        if ($age !== ""){
            $profile->setAge($age);
        }
        if ($gender !== ""){
            $profile->setGender($gender);
        }
        if ($country !== ""){
            $profile->setCountry($country);
        }
        if ($picture !== ""){
            $profile->setProfilePicture($picture);
        }
        $profile->uploadProfile();
        return array("Success"=>$profileID);
    }

    private static function getProfileLevel($achievementScore){
        $level = 0;
        if ($achievementScore>0){
            $level = 1;
            if ($achievementScore >20){
                $level = 2;
                if($achievementScore >50){
                    $level = 3;
                }
            }
        }
        return $level;
    }

    public static function getAchievementDetails($achievementList){
        $achievementArray = [];
        foreach ($achievementList as $key => $count) {
            $achievement = new achievementController($key);
            $achievementArray[$achievement->getAchievementID()] = ["details"=>$achievement->returnVars(),"count"=>$count];
        }
        return $achievementArray;

    }
}