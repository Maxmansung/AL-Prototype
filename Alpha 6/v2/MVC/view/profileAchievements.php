<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class profileAchievements
{

    protected $profileID;
    protected $profilePicture;
    protected $gameStatus;
    protected $achievementsMain;
    protected $achievementsSpeed;
    protected $login;
    protected $accountType;
    protected $bio;
    protected $country;
    protected $gender;
    protected $age;
    protected $shrineScore;
    protected $conversion;

    private function __construct($id)
    {
        if ($id !== ""){
            $profile = new profileController($id);
            $this->profileID = $profile->getProfileID();
            $this->profilePicture = $profile->getProfilePicture();
            $this->gameStatus = $profile->getGameStatus();
            $this->achievementsMain = $profile->getAchievements();
            $this->achievementsSpeed = $profile->getAchievementsSolo();
            $this->login = $profile->getLastLogin();
            $this->accountType = $profile->getAccountType();
            $this->bio = $profile->getBio();
            $this->country = $profile->getCountry();
            $this->gender = $profile->getGender();
            $this->age = $profile->getAge();
            $this->shrineScore = $profile->getShrineScore();
            $this->calculateLoginTime();
            $this->createAchievements();
        }
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