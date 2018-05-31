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

    public function getProfileAccess(){
        profileModel::getProfileAccess($this);
    }

    public function __construct($id)
    {
        if ($id != ""){
            $checker = intval($id);
            if ($checker != 0 && $id == $checker){
                $checkprofile = profileModel::getProfile($id);
            } else {
                $checkprofile = profileModel::checkname($id);
            }
            $this->profileID = $checkprofile->getProfileID();
            $this->profileName = $checkprofile->getProfileName();
            $this->password = $checkprofile->getPassword();
            $this->profilePicture = $checkprofile->getProfilePicture();
            $this->email = $checkprofile->getEmail();
            $this->lastlogin = $checkprofile->getLastLogin();
            $this->loginIP = $checkprofile->getLoginIP();
            $this->accountType = $checkprofile->getAccountType();
            $this->gameStatus = $checkprofile->getGameStatus();
            $this->avatarID = $checkprofile->getAvatar();
            $this->passwordRecovery = $checkprofile->getPasswordRecovery();
            $this->passwordRecoveryTimer = $checkprofile->getPasswordRecoveryTimer();
            $this->cookieKey = $checkprofile->getCookieKey();
            $this->forumPosts = $checkprofile->getForumPosts();
            $this->postsNew = $this->checkForNewPosts();
            $this->nightfall = data::getNightfall();
            $this->reportTimer = $checkprofile->getReportTimer();
            $this->createdMap = $checkprofile->getCreatedMap();
        }
    }

    //This function checks the login details on each page to ensure the session or cookies have not been edited
    private static function checklogin(){
        $checkprofile = new profileController($_SESSION["username"]);
        if ($_SESSION["username"] == $checkprofile->getProfileID()) {
            if ($_SESSION["ip"] != $checkprofile->getLoginIP()){
                $checkprofile->setLoginIP(preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')));
                $checkprofile->uploadProfile();
                $response = array("ALERT"=>"0","DATA"=>"IP");
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
                        $_SESSION["ip"] = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
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
    public static function login($username, $p, $cookies,$confirm)
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
            } else if ($checkprofile->accountType == 8 && $confirm !== true) {
                return array("ERROR"=>104);
            } else {
                // CREATE THEIR SESSIONS
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $checkprofile->setLoginIP(preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')));
                $_SESSION['username'] = $checkprofile->getProfileID();
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
                    return array("ALERT"=>0,"DATA"=>0);
                } else {
                    $checkprofile->uploadProfile();
                    return array("ALERT"=>0,"DATA"=>0);
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
                $this->setProfileName($u);
                $this->setEmail($e);
                $this->setLoginIP($ip);
                $this->setAccountType(8);
                $this->setgameStatus("ready");
                $this->setProfilePicture(null);
                $this->setAvatar(null);
                $this->setProfilePicture("generic.png");
                $this->achievements = new stdClass();
                // Add user info into the database table for the main site table
                profileModel::insertProfile($this, "Insert");
                $checkPosted = new profileController($u);
                if ($checkPosted->getProfileID() != 0) {
                    profileDetailsController::newProfileCreation($checkPosted->getProfileID() );
                    // Email the user their activation link
                    $response = emails::sendEmail($checkPosted->getProfileName(), $checkPosted->getProfileID() , $e, $this->getPassword(), "confirm");
                    if ($response === "SUCCESS") {
                        return array("ALERT" => 22,"DATA"=>$this->getEmail());
                    } else {
                        return array("ERROR" => "The email has not sent");
                    }
                } else {
                    return array("ERROR" => "The profile has not been created due to an unknown database error");
                }
            }
        }
    }

    public function activate($username, $email, $password)
    {
        $u = preg_replace('#[^0-9]#i', '', $username);
        $e = filter_var($email, FILTER_SANITIZE_EMAIL);
        // Evaluate the lengths of the incoming $_GET variable
        if (strlen($e) < 5 || $password == "") {
            // Log this issue into a text file and email details to yourself
            return array("ERROR"=>0);
        }
        // Check their credentials against the database
        $checkprofile = new profileController($u);
        // Evaluate for a match in the system (0 = no match, 1 = match)
        if ($checkprofile->profileID == "") {
            // Log this potential hack attempt to text file and email details to yourself
            return array("ERROR"=>1);
        }
        if ($password !== $checkprofile->getPassword()) {
            return array("ERROR"=>2);
        }
        $checkprofile->getProfileAccess();
        if ($checkprofile->getAccessActivated() === 1){
            return array("ERROR"=>3);
        }
        return array("ALERT"=>23,"DATA"=>$checkprofile->getProfileName());
    }


    public static function activateConfirm($username,$password){
        $checker = self::login($username,$password,false,true);
        if (array_key_exists("ERROR", $checker)){
            return $checker;
        } else {
            $profile = new profileController($username);
            $profile->setAccountType(7);
            $mapID = mapModel::getTutorialMap();
            if ($mapID != 0){
                $response = newMapJoinController::addAvatar($mapID,$profile);
                if (array_key_exists("ERROR",$response)){
                    return $response;
                } else {
                    $profile->uploadProfile();
                    return array("ALERT"=>23,"DATA"=>"");
                }
            } else {
                $profile->uploadProfile();
                return array("ERROR" => "There are no tutorial maps currently, however your account has been activated");
            }
        }
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
                    $response = emails::sendEmail($profile->getProfileName(),$profile->getProfileID(),$profile->getEmail(),$profile->getPasswordRecovery(),"recover");
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
        $profileDetails = new profileDetailsController($this->profileID);
        $response = $profileDetails->updateProfileDetails($bio,$age,$gender,$country);
        return $response;
    }

    public static function changePlayerRank($profile,$changeProfile,$rank){
        $profile->getProfileAccess();
        if ($profile->getAccessEditUsers() === 1){
            $profileIDClean = intval(preg_replace(data::$cleanPatterns['num'],"",$changeProfile));
            $newProfile = new profileController($profileIDClean);
            $old = $newProfile->getAccountType();
            if ($newProfile->getProfileID() !== $profileIDClean){
                return array("ERROR"=>37);
            } else {
                if ($profile->getAccountType() >= $newProfile->getAccountType()) {
                    return array("ERROR" => 28);
                } else {
                    $rankClean = intval(preg_replace(data::$cleanPatterns['num'],"",$rank));
                    if ($profile->getAccountType() >= $rankClean){
                        return array("ERROR"=>28);
                    } else {
                        modTrackingController::createNewTrack(9,$profile->getProfileID(),$newProfile->getProfileID(),$rankClean,$old,"");
                        $newProfile->setAccountType($rankClean);
                        $newProfile->uploadProfile();
                        $dataArray = array("name"=>$newProfile->getProfileName(),"old"=>$old,"new"=>$newProfile->getAccountType());
                        return array("ALERT"=>2,"DATA"=>$dataArray);
                    }
                }
            }
        } else {
            return array("ERROR"=>28);
        }
    }
}