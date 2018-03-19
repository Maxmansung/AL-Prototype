<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileModel extends profile
{
    private function __construct($profileModel)
    {
        $this->profileID = $profileModel['id'];
        $this->password = $profileModel['password'];
        $this->profilePicture = $profileModel['profilepicture'];
        $this->email = $profileModel['email'];
        $this->lastlogin = $profileModel['login'];
        $this->loginIP = $profileModel['ip'];
        $this->accountType = $profileModel['AccountType'];
        $this->gameStatus = $profileModel['gamestatus'];
        $this->avatarID = $profileModel['avatar'];
        if (is_object(json_decode($profileModel['achievements']))) {
            $this->achievements = get_object_vars(json_decode($profileModel['achievements']));
        } else {
            $this->achievements = array();
        }
        if (is_object(json_decode($profileModel['achievementsSolo']))) {
            $this->achievementsSolo = get_object_vars(json_decode($profileModel['achievementsSolo']));
        } else {
            $this->achievementsSolo = array();
        }
        $this->bio = $profileModel['bio'];
        $this->country = $profileModel['country'];
        $this->gender = $profileModel['gender'];
        $this->age = $profileModel['age'];
        if (is_object(json_decode($profileModel['playStatistics']))) {
            $this->playStatistics = get_object_vars(json_decode($profileModel['playStatistics']));
        } else {
            $this->playStatistics = array();
        }
        $this->uploadSecurity = $profileModel['uploadSecurity'];
        $this->passwordRecovery = $profileModel['passwordRecovery'];
        $this->passwordRecoveryTimer = $profileModel['passwordRecoveryTimer'];
        $this->cookieKey = $profileModel['cookieKey'];
        if (is_object(json_decode($profileModel['shrineScore']))) {
            $this->shrineScore = get_object_vars(json_decode($profileModel['shrineScore']));
        } else {
            $this->shrineScore = array();
        }
        $this->forumPosts = json_decode($profileModel['forumPosts']);
    }

    //This function finds a profile by player name
    public static function checkname($profileID) {
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
        $profileID = $profileController->getProfileID();
        $password2 = $profileController->getPassword();
        $profilePicture = $profileController->getProfilePicture();
        $email = $profileController->getEmail();
        $lastLogin = $profileController->getLastLogin();
        $loginIP = $profileController->getLoginIP();
        $accountType = $profileController->getAccountType();
        $gameStatus = $profileController->getGameStatus();
        $avatar =  $profileController->getAvatar();
        $achievements = json_encode($profileController->getAchievements());
        $achievementsSolo = json_encode($profileController->getAchievementsSolo());
        $bio = $profileController->getBio();
        $country = $profileController->getCountry();
        $gender = $profileController->getGender();
        $age = $profileController->getAge();
        $playStatistics = json_encode($profileController->getPlayStatistics());
        $uploadSecurity = $profileController->getUploadSecurity();
        $passwordRecovery = $profileController->getPasswordRecovery();
        $passwordRecoveryTimer = $profileController->getPasswordRecoveryTimer();
        $cookieKey = $profileController->getCookieKey();
        $shrineScore = json_encode($profileController->getShrineScore());
        $forumPosts = json_encode($profileController->getForumPosts());

        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Profile (id, password, profilepicture, email, login, ip, AccountType, gamestatus, avatar, achievements, achievementsSolo, bio, country, gender, age, playStatistics, uploadSecurity, passwordRecovery, passwordRecoveryTimer, cookieKey, shrineScore, forumPosts) VALUES (:profileID, :password2, :profilePicture, :email, :lastLogin, :loginIP, :accountType, :gameStatus, :avatar, :achievements, :achievementsSolo, :bio, :country, :gender, :age, :playStatistics, :uploadSecurity, :passwordRecovery, :passwordRecoveryTimer, :cookieKey, :shrineScore,:forumPosts)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Profile SET password= :password2, profilepicture= :profilePicture, email= :email, login= :lastLogin, ip= :loginIP, AccountType= :accountType, gamestatus= :gameStatus, avatar= :avatar, achievements= :achievements, achievementsSolo= :achievementsSolo, bio= :bio, country= :country, gender= :gender, age= :age, playStatistics= :playStatistics, uploadSecurity= :uploadSecurity, passwordRecovery= :passwordRecovery, passwordRecoveryTimer= :passwordRecoveryTimer, cookieKey= :cookieKey, shrineScore= :shrineScore,forumPosts= :forumPosts WHERE id= :profileID");
        }
        $req->bindParam(':profileID', $profileID);
        $req->bindParam(':password2', $password2);
        $req->bindParam(':profilePicture', $profilePicture);
        $req->bindParam(':email', $email);
        $req->bindParam(':lastLogin', $lastLogin);
        $req->bindParam(':loginIP', $loginIP);
        $req->bindParam(':accountType', $accountType);
        $req->bindParam(':gameStatus', $gameStatus);
        $req->bindParam(':avatar', $avatar);
        $req->bindParam(':achievements', $achievements);
        $req->bindParam(':achievementsSolo', $achievementsSolo);
        $req->bindParam(':bio', $bio);
        $req->bindParam(':country', $country);
        $req->bindParam(':gender', $gender);
        $req->bindParam(':age', $age);
        $req->bindParam(':playStatistics', $playStatistics);
        $req->bindParam(':uploadSecurity', $uploadSecurity);
        $req->bindParam(':passwordRecovery', $passwordRecovery);
        $req->bindParam(':passwordRecoveryTimer', $passwordRecoveryTimer);
        $req->bindParam(':cookieKey', $cookieKey);
        $req->bindParam(':shrineScore', $shrineScore);
        $req->bindParam(':forumPosts', $forumPosts);
        $req->execute();
    }

    //This function finds all profiles with a partial name
    public static function findAllProfiles($username) {
        $adjustedUsername = "%".$username."%";
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT id FROM Profile WHERE id LIKE :adjustedUsername ORDER BY id ASC");
        $req->execute(array(':adjustedUsername' => $adjustedUsername));
        $profileModel = $req->fetchAll();
        $counter = 0;
        $finalArray = [];
        foreach ($profileModel as $profile){
            $finalArray[$counter] = $profile['id'];
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
}