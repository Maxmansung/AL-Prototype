<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileModel extends profile
{
    private function __construct($profileModel)
    {
        $this->profileID = intval($profileModel['id']);
        $this->profileName = $profileModel['profileName'];
        $this->password = $profileModel['password'];
        $this->profilePicture = $profileModel['profilepicture'];
        $this->gameStatus = $profileModel['gamestatus'];
        $this->avatarID = intval($profileModel['avatar']);
        $this->email = $profileModel['email'];
        $this->lastlogin = $profileModel['login'];
        $this->loginIP = $profileModel['ip'];
        $this->accountType = intval($profileModel['AccountType']);
        $this->passwordRecovery = $profileModel['passwordRecovery'];
        $this->passwordRecoveryTimer = intval($profileModel['passwordRecoveryTimer']);
        $this->cookieKey = $profileModel['cookieKey'];
        $this->forumPosts = json_decode($profileModel['forumPosts']);
        $this->reportTimer = intval($profileModel['reportTimer']);
        $this->createdMap = intval($profileModel['createdMap']);
    }

    //This function finds a profile by player name
    public static function checkname($profileName) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Profile WHERE profileName= :profileName LIMIT 1');
        $req->bindParam(':profileName', $profileName);
        $req->execute();
        $profileModel = $req->fetch();
        return new profileModel($profileModel);
    }

    //This function finds a profile by player name
    public static function getProfile($profileID) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Profile WHERE id= :profileID LIMIT 1');
        $req->bindParam(':profileID', $profileID);
        $req->execute();
        $profileModel = $req->fetch();
        return new profileModel($profileModel);
    }

    //This function finds a profile by email
    public static function checkemail($email) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Profile WHERE email= :email LIMIT 1');
        // the query was prepared, now we replace :name with our actual $id value
        $req->bindParam(':email', $email);
        $req->execute();
        $profileModel = $req->fetch();
        return new profileModel($profileModel);
    }

    //This updates or creates a new entry for the profile table
    public static function insertProfile($profileController, $type){
        $profileID = intval($profileController->getProfileID());
        $profileName = $profileController->getProfileName();
        $password2 = $profileController->getPassword();
        $profilePicture = $profileController->getProfilePicture();
        $gameStatus = $profileController->getGameStatus();
        $avatar =  intval($profileController->getAvatar());
        if ($avatar === 0){
            $avatar = null;
        }
        $email = $profileController->getEmail();
        $lastLogin = $profileController->getLastLogin();
        $loginIP = $profileController->getLoginIP();
        $accountType = intval($profileController->getAccountType());
        $passwordRecovery = $profileController->getPasswordRecovery();
        $passwordRecoveryTimer = intval($profileController->getPasswordRecoveryTimer());
        $cookieKey = $profileController->getCookieKey();
        $forumPosts = json_encode($profileController->getForumPosts());
        $reportTimer = intval($profileController->getReportTimer());
        $createdMap = intval($profileController->getCreatedMap());
        if ($createdMap === 0){
            $createdMap = null;
        }

        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Profile (profileName, password, profilepicture, gamestatus, avatar, email, login, ip, AccountType, passwordRecovery, passwordRecoveryTimer, cookieKey, forumPosts, reportTimer, createdMap) VALUE (:profileName, :password2, :profilePicture, :gameStatus, :avatar, :email, :lastLogin, :loginIP, :accountType, :passwordRecovery, :passwordRecoveryTimer, :cookieKey, :forumPosts, :reportTimer, :createdMap)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Profile SET profileName= :profileName, password= :password2, profilepicture= :profilePicture, gamestatus= :gameStatus, avatar= :avatar, email= :email, login= :lastLogin, ip= :loginIP, AccountType= :accountType, passwordRecovery= :passwordRecovery, passwordRecoveryTimer= :passwordRecoveryTimer, cookieKey= :cookieKey, forumPosts= :forumPosts, reportTimer= :reportTimer, createdMap= :createdMap WHERE id= :profileID");
            $req->bindParam(':profileID', $profileID);
        }
        $req->bindParam(':profileName', $profileName);
        $req->bindParam(':password2', $password2);
        $req->bindParam(':profilePicture', $profilePicture);
        $req->bindParam(':gameStatus', $gameStatus);
        $req->bindParam(':avatar', $avatar);
        $req->bindParam(':email', $email);
        $req->bindParam(':lastLogin', $lastLogin);
        $req->bindParam(':loginIP', $loginIP);
        $req->bindParam(':accountType', $accountType);
        $req->bindParam(':passwordRecovery', $passwordRecovery);
        $req->bindParam(':passwordRecoveryTimer', $passwordRecoveryTimer);
        $req->bindParam(':cookieKey', $cookieKey);
        $req->bindParam(':forumPosts', $forumPosts);
        $req->bindParam(':reportTimer', $reportTimer);
        $req->bindParam(':createdMap', $createdMap);
        $req->execute();
        if ($type == "Insert"){
            $check = intval($db->lastInsertId());
            return $check;
        }
    }

    //This function finds all profiles with a partial name
    public static function findAllProfiles($username) {
        $adjustedUsername = "%".$username."%";
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM Profile WHERE profileName LIKE :adjustedUsername ORDER BY profileName ASC");
        $req->execute(array(':adjustedUsername' => $adjustedUsername));
        $profileModel = $req->fetchAll();
        $counter = 0;
        $finalArray = [];
        foreach ($profileModel as $profile){
            $finalArray[$counter] = new profileModel($profile);
            $counter++;
        }
        return $finalArray;
    }

    //This function finds all profiles with a partial name
    public static function getAllProfileID() {
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT id FROM Profile");
        $req->execute();
        $profileModel = $req->fetchAll();
        $counter = 0;
        $finalArray = [];
        foreach ($profileModel as $profile){
            $finalArray[$counter] = $profile['id'];
            $counter++;
        }
        return $finalArray;
    }

    public static function getProfileAccess($profileController)
    {
        $rank = $profileController->getAccountType();
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM AccountType WHERE rank= :rank LIMIT 1');
        $req->bindParam(':rank', $rank);
        $req->execute();
        $profileModel = $req->fetch();
        $profileController->setAccessNewMap(intval($profileModel['newMap']));
        $profileController->setAccessEditMap(intval($profileModel['editMap']));
        $profileController->setAccessEditForum(intval($profileModel['editForum']));
        $profileController->setAccessPostNews(intval($profileModel['postNews']));
        $profileController->setAccessActivated(intval($profileModel['activated']));
        $profileController->setAccessAllGames(intval($profileModel['allGames']));
        $profileController->setAccessAdminPage(intval($profileModel['adminPage']));
    }
}