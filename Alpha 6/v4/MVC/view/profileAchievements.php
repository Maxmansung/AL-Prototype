<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class profileAchievements
{

    protected $profileID;
    protected $profileName;
    protected $profilePicture;
    protected $gameStatus;
    protected $login;
    protected $accountType;
    protected $age;
    protected $gender;
    protected $keyAchievement1;
    protected $keyAchievement2;
    protected $keyAchievement3;
    protected $keyAchievement4;
    protected $favouriteGod;
    protected $country;
    protected $mainGames;
    protected $speedGames;
    protected $bio;
    protected $achievementsMain;
    protected $achievementsSpeed;
    protected $shrineScore;
    protected $soloLeaderboard;
    protected $teamLeaderboard;
    protected $fullLeaderboard;

    private function __construct($id)
    {
        if ($id !== ""){
            $profile = new profileController($id);
            $profileDetails = new profileDetailsController($profile->getProfileID());
            $this->profileID = $profile->getProfileID();
            $this->profileName = $profile->getProfileName();
            $this->profilePicture = $profile->getProfilePicture();
            $this->gameStatus = $profile->getGameStatus();
            $this->login = $profile->getLastLogin();
            $this->accountType = profileDetailsModel::getProfileAccountType($profile->getAccountType());
            $this->age = $profileDetails->getAge();
            $this->gender = $profileDetails->getGender();
            $this->keyAchievement1 = $profileDetails->getKeyAchievement1();
            $this->keyAchievement2 = $profileDetails->getKeyAchievement2();
            $this->keyAchievement3 = $profileDetails->getKeyAchievement3();
            $this->keyAchievement4 = $profileDetails->getKeyAchievement4();
            $name = "shrine".$profileDetails->getFavouriteGod();
            $shrine = new $name();
            $this->favouriteGod = $shrine->getShrineName();
            $this->country = $profileDetails->getCountry();
            $this->mainGames = $profileDetails->getMainGames();
            $this->speedGames = $profileDetails->getSpeedGames();
            $this->bio = $profileDetails->getBio();
            $this->achievementsMain = $profileDetails->getAchievements();
            $this->achievementsSpeed = $profileDetails->getAchievementsSolo();
            $this->soloLeaderboard = $profileDetails->getSoloLeaderboard();
            $this->teamLeaderboard = $profileDetails->getTeamLeaderboard();
            $this->fullLeaderboard = $profileDetails->getFullLeaderboard();
            $this->calculateShrines();
            $this->calculateLoginTime();
            $this->createAchievements();
        }
    }

    private function calculateShrines(){
        $this->shrineScore = $this->soloLeaderboard+$this->teamLeaderboard+$this->fullLeaderboard;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function getView($id){
        $view = new profileAchievements($id);
        return $view->returnVars();
    }

    private function calculateLoginTime(){
        $actual = strtotime($this->login);
        $current = time();
        $difference = $current - $actual;
        $midnight = strtotime("today midnight");
        if ($actual > $midnight){
            $response = "Today";
        } else {
            if ($difference < (86400*3)) {
                $response = "Last 3 days";
            } else {
                $response = date("j-M",$actual);
            }
        }
        $this->login = $response;
    }

    private function createAchievements(){
        foreach ($this->achievementsMain as $achievement=>$count){
            $temp = new achievementController($achievement);
            $temp2 = array("details"=>$temp->returnVars(),"count"=>$count);
            $this->achievementsMain[$achievement] = $temp2;
        }
        foreach ($this->achievementsSpeed as $achievement=>$count){
            $temp = new achievementController($achievement);
            $temp2 = array("details"=>$temp->returnVars(),"count"=>$count);
            $this->achievementsSpeed[$achievement] = $temp2;
        }
    }

}