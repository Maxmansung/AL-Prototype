<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/profile.php");
require_once(PROJECT_ROOT."/MVC/model/profileModel.php");
class profileController extends profile
{

    protected $postsNew;
    protected $nightfall;

    function getPostsNew(){
        return $this->postsNew;
    }

    function getNightfall(){
        return $this->nightfall;
    }

    public function __construct($id)
    {
        if ($id != ""){
            $checkprofile = profileModel::checkname($id);
            $this->profileID = $checkprofile->getProfileID();
            $this->password = $checkprofile->getPassword();
            $this->profilePicture = $checkprofile->getProfilePicture();
            $this->email = $checkprofile->getEmail();
            $this->lastlogin = $checkprofile->getLastLogin();
            $this->loginIP = $checkprofile->getLoginIP();
            $this->accountType = $checkprofile->getAccountType();
            $this->gameStatus = $checkprofile->getGameStatus();
            $this->avatarID = $checkprofile->getAvatar();
            $this->achievements = $checkprofile->getAchievements();
            $this->achievementsSolo = $checkprofile->getAchievementsSolo();
            $this->bio = $checkprofile->getBio();
            $this->country = $checkprofile->getCountry();
            $this->gender = $checkprofile->getGender();
            $this->age = $checkprofile->getAge();
            $this->playStatistics = $checkprofile->getPlayStatistics();
            $this->uploadSecurity = $checkprofile->getUploadSecurity();
            $this->passwordRecovery = $checkprofile->getPasswordRecovery();
            $this->passwordRecoveryTimer = $checkprofile->getPasswordRecoveryTimer();
            $this->cookieKey = $checkprofile->getCookieKey();
            $this->shrineScore = $checkprofile->getShrineScore();
            $this->forumPosts = $checkprofile->getForumPosts();
            $this->postsNew = $this->checkForNewPosts();
            $this->nightfall = data::getNightfall();
            $this->reportTimer = $checkprofile->getReportTimer();
        }
    }

    //This function checks the login details on each page to ensure the session or cookies have not been edited
    private static function checklogin(){
        $checkprofile = new profileController($_SESSION["username"]);
        if ($_SESSION["username"] == $checkprofile->getProfileID()) {
            if ($_SESSION["ip"] != $checkprofile->getLoginIP()){
                $checkprofile->setLoginIP(preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')));
                $checkprofile->uploadProfile();
                $response = array("ERROR"=>"IP address does not match");
            } else {
                $response = array("SUCCESS"=>$checkprofile->getProfileID());
            }
        } else {
            $response = profileController::destroysession();
        }
        return $response;
    }

    public function uploadProfile(){
        profileModel::insertProfile($this,"Update");
    }

    public static function userlogin()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["type"])) {
            $type = $_SESSION["type"];
        }
        if (isset($_COOKIE["type"])) {
            $type = $_COOKIE["type"];
        }
        if (isset($type)){
            switch ($type) {
                case "main":
                    if (isset($_SESSION["ip"]) && isset($_SESSION["username"])) {
                        $response = profileController::checklogin();
                    } else {
                        $username = profileController::checkCookies();
                        if ($username != false) {
                            $response = array("SUCCESS" => $username);
                        } else {
                            $response = array("ERROR" => "No session or cookies created");
                        }
                    }
                    return $response;
                    break;
                case "google":
                    return array("ERROR"=>"This has not yet been implimented");
                    break;
                default:
                    return array("ERROR"=>"This session type does not exist");
                    break;
            }
        }
        self::destroysession();
        return array("ERROR"=>"Incorrect session created");
    }

    //This destroys a users session if the session details are incorrect of corrupted
    public static function destroysession()
    {
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
        }
        // Set Session data to an empty array
        $_SESSION = array();
        // Expire their cookie files
        if (isset($_COOKIE["loginKey"])) {
            setcookie("loginKey", '', strtotime('-5 days'), '/',SITE_ADDRESS);
        }
        // Destroy the session variables
        session_destroy();
        session_unset();
        // Double check to see if their sessions exists
        if (isset($_SESSION['username'])) {
            return array("ERROR"=>110);
        }
        return array("ERROR"=>58);
    }

    //This function performs the AJAX login script
    public static function login($username, $p, $cookies)
    {
        // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
        $u = preg_replace('#[^A-Za-z0-9]#i', '', $username);
        if ($cookies === "false"){
            $c = false;
        } else {
            $c = boolval($cookies);
        }
        // FORM DATA ERROR HANDLING
        if ($u == "" || $p == "") {
            return array("ERROR"=>101);
        } else {
            $checkprofile = new profileController($u);
            if ($checkprofile->profileID == "") {
                return array("ERROR"=>102);
            }
            if (!password_verify($p,$checkprofile->getPassword())) {
                return array("ERROR"=>103);
            } else if ($checkprofile->accountType == 8) {
                return array("ERROR"=>104);
            } else {
                // CREATE THEIR SESSIONS
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $checkprofile->setLoginIP(preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')));
                $_SESSION['username'] = $checkprofile->profileID;
                $_SESSION['ip'] = $checkprofile->getLoginIP();
                $_SESSION['type'] = "main";
                if ($c === true){
                    $checkprofile->setCookieKey();
                    $cookieUpload = $checkprofile->getProfileID() . ':' . $checkprofile->getCookieKey();
                    $mac = hash_hmac('sha256', $cookieUpload, data::$salt["salt"]);
                    $cookieUpload .= ':' . $mac;
                    setcookie('loginKey', $cookieUpload, time() + (86400 * 30),"/",SITE_ADDRESS);
                    setcookie('type', "main", time() + (86400 * 30),"/",SITE_ADDRESS);
                    $checkprofile->setLastLogin(date("Y-m-d H:i"));
                    $checkprofile->uploadProfile();
                    return array("ALERT"=>0,"DATA"=>$c);
                } else {
                    $checkprofile->uploadProfile();
                    return array("ALERT"=>0,"DATA"=>$c);
                }
            }
        }
    }

    public static function checkCookies()
    {
        $cookie = isset($_COOKIE['loginKey']) ? $_COOKIE['loginKey'] : '';
        if ($cookie) {
            list ($user, $key, $mac) = explode(':', $cookie);
            if (hash_hmac('sha256', $user . ':' . $key, data::$salt["salt"]) != $mac) {
                return false;
            } else {
                $profile = new profileController($user);
                $usertoken = $profile->getCookieKey();
                if ($usertoken === $key) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $profile->setLoginIP(preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')));
                    $_SESSION['username'] = $user;
                    $_SESSION['ip'] = $profile->getLoginIP();
                    return $user;
                }
                else {
                    return false;
                }
            }
        }
        return false;
    }

    //This script checks to see if the username has been taken on the signup page
    public function usernamecheck($u){
        $username = preg_replace('#[^A-Za-z0-9]#i', '', $u);
        $checkprofile = profileModel::checkname($username);
        if (strlen($username) < 3 || strlen($username) > 16) {
            echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
            exit();
        }
        if (is_numeric($username[0])) {
            echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
            exit();
        }
        if ($checkprofile->profileID == "") {
            echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
            exit();
        } else {
            echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
            exit();
        }
    }

    //This function checks the login data and posts it to the database
    public function signup($username, $email, $p,$security){
        $u = preg_replace('#[^A-Za-z0-9]#i', '', $username);
        $eCheck = strtolower($email);
        $e = strtolower(filter_var($email, FILTER_SANITIZE_EMAIL));
        $sec =  preg_replace('#[^A-Za-z0-9]#i', '', $security);
        // GET USER IP ADDRESS
        $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
        if ($u !== $username){
            return array("ERROR"=>119);
        } elseif ($e !== $eCheck){
            return array("ERROR"=>120);
        } else {
            // DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
            $checkprofile = profileModel::checkname($u);
            $checkemail = profileModel::checkemail($e);
            // FORM DATA ERROR HANDLING
            if ($u == "" || $e == "" || $p == "" || $sec == "") {
                return array("ERROR" => 105);
            } else if ($checkprofile->profileID != "") {
                return array("ERROR" => 106);
            } else if ($checkemail->profileID != "") {
                return array("ERROR" => 107);
            } else if (strlen($u) < 3 || strlen($u) > 16) {
                return array("ERROR" => 108);
            } else if (is_numeric($u[0])) {
                return array("ERROR" => 109);
            } else if ($sec != data::$adminVar["loginPassword"]) {
                return array("ERROR" => 110);
            } else {
                // END FORM DATA ERROR HANDLING
                $password = data::hashPassword($p);
                $this->setPassword($password);
                $this->setProfileID($u);
                $this->setEmail($e);
                $this->setLoginIP($ip);
                $this->setAccountType(8);
                $this->setgameStatus("ready");
                $this->setProfilePicture(null);
                $this->setAvatar(null);
                $this->setBio("Bio goes here");
                $this->setCountry("Unknown");
                $this->setGender("unknown");
                $this->setProfilePicture("generic.png");
                $this->setAge(100);
                $this->achievements = new stdClass();
                // Add user info into the database table for the main site table
                profileModel::insertProfile($this, "Insert");
                // Email the user their activation link
                $response = emails::sendEmail($u, $e, $this->getPassword(), "confirm");
                if ($response === "SUCCESS") {
                    return array("Success" => true);
                } else {
                    return array("ERROR" => "The email has not sent");
                }
            }
        }
    }

    public function activate($username, $email, $password)
    {
        $u = preg_replace('#[^a-z0-9]#i', '', $username);
        $e = filter_var($email, FILTER_SANITIZE_EMAIL);
        $p = filter_var($password, FILTER_SANITIZE_STRING);
        // Evaluate the lengths of the incoming $_GET variable
        if (strlen($u) < 3 || strlen($e) < 5 || $p == "") {
            // Log this issue into a text file and email details to yourself
            header("location: message.php?msg=Get values are not correctly set");
            exit();
        }
        // Check their credentials against the database
        $checkprofile = profileModel::checkname($u);
        // Evaluate for a match in the system (0 = no match, 1 = match)
        if ($checkprofile->profileID == "") {
            // Log this potential hack attempt to text file and email details to yourself
            header("location: message.php?msg=No player within the system with these details");
            exit();
        }$checkprofile->setAccountType(7);
        // Match was found, you can activate them
        profileModel::insertProfile($checkprofile, "Update");
    }

    public function confirmdeath(){
        $deathScreen = new deathScreenController($this->profileID);
        if ($deathScreen->getDayDuration() == "full" && $deathScreen->getGameType() != "Test") {
            if ($deathScreen->getDeathAchievements() != "") {
                $this->addAchievements($deathScreen->getDeathAchievements());
            }
            if ($deathScreen->getShrineScore() != ""){
                $this->addShrineScores($deathScreen->getShrineScore());
            }
        }
        if ($deathScreen->getDayDuration() == "check" && $deathScreen->getGameType() != "Test"){
            if ($deathScreen->getDeathAchievements() != "") {
                $this->addAchievementsSolo($deathScreen->getDeathAchievements());
            }
        }
        if ($deathScreen->getGameType() == "Main") {
            if ($deathScreen->getDeathStatistics() != "") {
                foreach ($deathScreen->getDeathStatistics() as $type => $stat) {
                    $this->addPlayStatistics($type, $stat);
                }
            }
        }
        $this->setGameStatus("ready");
        $this->setAvatar(null);
        $deathScreen->deleteDeathScreen();
        $this->uploadProfile();
        $profileAchievements = new profileAchievementController($this,$this->profileID);
        if ($profileAchievements->getProfileScore() > 4){
            if (data::$adminVar['autoTutorial'] == true) {
                if ($this->accountType == 7) {
                    $this->setAccountType(6);
                    $this->uploadProfile();
                    return array("ERROR" => 53);
                }
            }
        }
        return array("ERROR"=>56);
    }

    public static function findProfiles($name){
        $nameArray = profileModel::findAllProfiles($name);
        $finalArray = [];
        $counter = 0;

        foreach ($nameArray as $profile){
            $player = new profileController($profile);
            $finalArray[$counter] = array("profile"=>$player->getProfileID(),"profileImage"=>$player->getProfilePicture(),"login"=>$player->calculateLoginTime());
            $counter ++;
        }
        return $finalArray;
    }

    public static function createRecoveryPassword($e)
    {
        $email = strtolower(filter_var($e, FILTER_SANITIZE_EMAIL));
        $profile = profileModel::checkemail($e);
        $username = $profile->getProfileID();
        if ($username == ""){
            return array("ERROR"=>111);
        } else {
            if (strtolower($profile->getEmail()) != $email){
                return array("ERROR"=>112);
            } else {
                $timeDifference = time() - $profile->getPasswordRecoveryTimer();
                if ($timeDifference <= 300) {
                    return array("ERROR" => 113);
                }
                $profile = new profileController($username);
                $profile->setPasswordRecovery();
                $profile->setPasswordRecoveryTimer();
                $profile->uploadProfile();
                $checkProfile = new profileController($username);
                if ($checkProfile->getPasswordRecovery() !== $profile->getPasswordRecovery()) {
                    return array("ERROR" => 114);
                } else {
                    // Email the user their activation link
                    $response = emails::sendEmail($profile->getProfileID(),$profile->getEmail(),$profile->getPasswordRecovery(),"recover");
                    if ($response === "SUCCESS") {
                        return array("ALERT" => 13,"DATA"=>$email);
                    } else {
                        return array("ERROR"=>"The email has not sent");
                    }
                }
            }
        }
    }

    public function updatePassword($newPassword,$security,$username){
        if ($this->getProfileID() != $username){
            return array("ERROR"=>115);
        } else {
            if ($security !== $this->getPasswordRecovery()){
                return array("ERROR"=>116);
            } else {
                if ($this->getPasswordRecovery() == "" || $this->getPasswordRecoveryTimer() == ""){
                    return array("ERROR"=>117);
                }
                $timeDifference = time() - $this->getPasswordRecoveryTimer();
                if ($timeDifference >3600){
                    return array("ERROR"=>118);
                } else {
                    $password = data::hashPassword($newPassword);
                    $this->setPassword($password);
                    $this->resetPasswordRecovery();
                    $this->uploadProfile();
                    return array("Success" => true);
                }
            }
        }
    }

    public static function addNewPostProfiles($postID){
        $profileArray = profileModel::getAllProfileID();
        foreach ($profileArray as $id){
            $tempProfile = new profileController($id);
            $tempProfile->addForumPosts($postID);
            $tempProfile->uploadProfile();
        }
    }

    private function checkForNewPosts(){
        if ($this->forumPosts !== array()){
            return true;
        } else {
            if ($this->avatarID !== null){
                $avatar = new avatarController($this->avatarID);
                if ($avatar->getForumPosts() !== array()){
                    return true;
                } else{
                    return false;
                }
            } else {
                return false;
            }
        }
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