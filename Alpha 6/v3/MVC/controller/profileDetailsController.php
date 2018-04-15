<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/profileDetails.php");
require_once(PROJECT_ROOT."/MVC/model/profileDetailsModel.php");
class profileDetailsController extends profileDetails
{

    function __construct($id)
    {
        if ($id != ""){
            $profileDetailsModel = profileDetailsModel::getProfileDetails($id);
            $this->profileID = $profileDetailsModel->getProfileID();
            $this->age = $profileDetailsModel->getAge();
            $this->gender = $profileDetailsModel->getGender();
            $this->keyAchievement1 = $profileDetailsModel->getKeyAchievement1();
            $this->keyAchievement2 = $profileDetailsModel->getKeyAchievement2();
            $this->keyAchievement3 = $profileDetailsModel->getKeyAchievement3();
            $this->keyAchievement4 = $profileDetailsModel->getKeyAchievement4();
            $this->favouriteGod = $profileDetailsModel->getFavouriteGod();
            $this->country = $profileDetailsModel->getCountry();
            $this->bio = $profileDetailsModel->getBio();
            $this->achievements = $profileDetailsModel->getAchievements();
            $this->achievementsSolo = $profileDetailsModel->getAchievementsSolo();
            $this->uploadSecurity = $profileDetailsModel->getUploadSecurity();
            $this->mainGames = $profileDetailsModel->getMainGames();
            $this->speedGames = $profileDetailsModel->getSpeedGames();
            $this->soloLeaderboard = $profileDetailsModel->getSoloLeaderboard();
            $this->teamLeaderboard = $profileDetailsModel->getTeamLeaderboard();
            $this->fullLeaderboard = $profileDetailsModel->getFullLeaderboard();
        }
    }

    public static function newProfileCreation($id)
    {
        $details = new profileDetailsController($id);
        if ($details->getProfileID() !== $id){
            $details->setProfileID($id);
            $details->setAge("100");
            $details->setGender("Unknown");
            $details->setCountry("Unknown");
            $details->setBio("Bio goes here");
            $details->setAchievements(array());
            $details->setAchievementsSolo(array());
            $details->setMainGames(0);
            $details->setSpeedGames(0);
            $details->setFavouriteGod("S000");
            profileDetailsModel::insertProfileDetails($details,"Insert");
        }
    }

    public function uploadProfile(){
        profileDetailsModel::insertProfileDetails($this,"Update");
    }

    public function updateProfileDetails($bio,$age,$gender,$country){
        $bioCheck = htmlentities($bio, ENT_QUOTES | ENT_SUBSTITUTE);
        $ageCheck = preg_replace('#[^0-9]#', '', $age);
        $genderCheck = preg_replace('/[^\w-, ]/', '',$gender);
        $countryCheck = filter_var($country, FILTER_SANITIZE_STRING);
        if ($bioCheck !== ""){
            $this->setBio($bioCheck);
        }
        if ($ageCheck !== ""){
            $this->setAge($ageCheck);
        }
        if ($genderCheck !== ""){
            $this->setGender($genderCheck);
        }
        if ($countryCheck !== ""){
            $this->setCountry($countryCheck);
        }
        $this->uploadProfile();
        return array("ALERT"=>14,"DATA"=>"None");
    }

    public static function updateFavouriteAchievements($profile,$achieve1,$achieve2,$achieve3,$achieve4){
        $profileDetails = new profileDetailsController($profile->getProfileID());
        if ($profileDetails->getProfileID() !== $profile->getProfileID()){
            return array("ERROR"=>"Incorrect profile");
        } else {
            $clean1 = preg_replace('#[^A-Za-z0-9]#i', '', $achieve1);
            $clean2 = preg_replace('#[^A-Za-z0-9]#i', '', $achieve2);
            $clean3 = preg_replace('#[^A-Za-z0-9]#i', '', $achieve3);
            $clean4 = preg_replace('#[^A-Za-z0-9]#i', '', $achieve4);
            if ($clean1 !== 0 && $clean1 !== "0") {
                $profileDetails->setKeyAchievement1($clean1);
            }
            if ($clean2 !== 0 && $clean2 !== "0") {
                $profileDetails->setKeyAchievement2($clean2);
            }
            if ($clean3 !== 0 && $clean3 !== "0") {
                $profileDetails->setKeyAchievement3($clean3);
            }
            if ($clean4 !== 0 && $clean4 !== "0") {
                $profileDetails->setKeyAchievement4($clean4);
            }
            $profileDetails->uploadProfile();
            return array("ALERT"=>14,"DATA"=>$profileDetails->returnVars());
        }
    }
}