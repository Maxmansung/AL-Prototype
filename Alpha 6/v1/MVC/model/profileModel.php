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
        $this->achievements = get_object_vars(json_decode($profileModel['achievements']));
        $this->achievementsSolo = get_object_vars(json_decode($profileModel['achievementsSolo']));
        $this->bio = $profileModel['bio'];
        $this->country = $profileModel['country'];
        $this->gender = $profileModel['gender'];
        $this->age = $profileModel['age'];
        $this->playStatistics = get_object_vars(json_decode($profileModel['playStatistics']));
        $this->uploadSecurity = $profileModel['uploadSecurity'];
        $this->passwordRecovery = $profileModel['passwordRecovery'];
        $this->passwordRecoveryTimer = $profileModel['passwordRecoveryTimer'];
        $this->cookieKey = $profileModel['cookieKey'];
        $this->shrineScore = get_object_vars(json_decode($profileModel['shrineScore']));
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
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Profile (id, password, profilepicture, email, login, ip, AccountType, gamestatus, avatar, achievements, achievementsSolo, bio, country, gender, age, playStatistics, uploadSecurity, passwordRecovery, passwordRecoveryTimer, cookieKey, shrineScore, forumPosts) VALUES (:profileID, :password2, :profilePicture, :email, :lastLogin, :loginIP, :accountType, :gameStatus, :avatar, :achievements, :achievementsSolo, :bio, :country, :gender, :age, :playStatistics, :uploadSecurity, :passwordRecovery, :passwordRecoveryTimer, :cookieKey, :shrineScore,:forumPosts)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Profile SET password= :password2, profilepicture= :profilePicture, email= :email, login= :lastLogin, ip= :loginIP, AccountType= :accountType, gamestatus= :gameStatus, avatar= :avatar, achievements= :achievements, achievementsSolo= :achievementsSolo, bio= :bio, country= :country, gender= :gender, age= :age, playStatistics= :playStatistics, uploadSecurity= :uploadSecurity, passwordRecovery= :passwordRecovery, passwordRecoveryTimer= :passwordRecoveryTimer, cookieKey= :cookieKey, shrineScore= :shrineScore,forumPosts= :forumPosts WHERE id= :profileID");
        }
        $req->bindParam(':profileID', $profileController->getProfileID());
        $req->bindParam(':password2', $profileController->getPassword());
        $req->bindParam(':profilePicture', $profileController->getProfilePicture());
        $req->bindParam(':email', $profileController->getEmail());
        $req->bindParam(':lastLogin', $profileController->getLastLogin());
        $req->bindParam(':loginIP', $profileController->getLoginIP());
        $req->bindParam(':accountType', $profileController->getAccountType());
        $req->bindParam(':gameStatus', $profileController->getGameStatus());
        $req->bindParam(':avatar', $profileController->getAvatar());
        $req->bindParam(':achievements', json_encode($profileController->getAchievements()));
        $req->bindParam(':achievementsSolo', json_encode($profileController->getAchievementsSolo()));
        $req->bindParam(':bio', $profileController->getBio());
        $req->bindParam(':country', $profileController->getCountry());
        $req->bindParam(':gender', $profileController->getGender());
        $req->bindParam(':age', $profileController->getAge());
        $req->bindParam(':playStatistics', json_encode($profileController->getPlayStatistics()));
        $req->bindParam(':uploadSecurity', $profileController->getUploadSecurity());
        $req->bindParam(':passwordRecovery', $profileController->getPasswordRecovery());
        $req->bindParam(':passwordRecoveryTimer', $profileController->getPasswordRecoveryTimer());
        $req->bindParam(':cookieKey', $profileController->getCookieKey());
        $req->bindParam(':shrineScore', json_encode($profileController->getShrineScore()));
        $req->bindParam(':forumPosts', json_encode($profileController->getForumPosts()));
        $req->execute();
    }

    //This function finds all profiles with a partial name
    public static function findAllProfiles($username) {
        $adjustedUsername = "%".$username."%";
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT id FROM Profile WHERE id LIKE :adjustedUsername");
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