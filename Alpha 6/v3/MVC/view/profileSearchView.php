<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileSearchView
{

    protected $profile;
    protected $profileID;
    protected $profileImage;
    protected $lastlogin;
    protected $login;

    function __construct($profileModel)
    {
        $this->profile = $profileModel->getProfileName();
        $this->profileID = $profileModel->getProfileID();
        $this->profileImage = $profileModel->getProfilePicture();
        $this->lastlogin = $profileModel->getLastLogin();
        $this->login = $this->calculateLoginTime();
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function findProfiles($name){
        $nameClean = preg_replace('#[^A-Za-z0-9]#i', '', $name);
        $nameArray = profileModel::findAllProfiles($nameClean);
        $finalArray = [];
        foreach ($nameArray as $profile){
            $player = new profileSearchView($profile);
            $finalArray[$player->profileID] = $player->returnVars();
        }
        return $finalArray;
    }


    private function calculateLoginTime(){
        $actual = strtotime($this->lastlogin);
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
        return $response;
    }

}