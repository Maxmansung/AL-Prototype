<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class profileDetailsModel extends profileDetails
{
    private function __construct($profileModel)
    {
        $this->profileID = intval($profileModel['profileID']);
        $this->bio = $profileModel['bio'];
        $this->country = $profileModel['country'];
        $this->gender = $profileModel['gender'];
        $this->age = intval($profileModel['age']);
        $this->keyAchievement1 = $profileModel['keyAchievement1'];
        $this->keyAchievement2 = $profileModel['keyAchievement2'];
        $this->keyAchievement3 = $profileModel['keyAchievement3'];
        $this->keyAchievement4 = $profileModel['keyAchievement4'];
        $this->favouriteGod = $profileModel['favouriteGod'];
        $this->uploadSecurity = $profileModel['uploadSecurity'];
        $this->mainGames = intval($profileModel['mainGames']);
        $this->speedGames = intval($profileModel['speedGames']);
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
        $this->soloLeaderboard = intval($profileModel['soloLeaderboard']);
        $this->teamLeaderboard = intval($profileModel['teamLeaderboard']);
        $this->fullLeaderboard = intval($profileModel['fullLeaderboard']);
    }

    //This function finds a profile by player name
    public static function getProfileDetails ($profileID) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM profileDetails WHERE profileID= :profileID LIMIT 1');
        $req->bindParam(':profileID', $profileID);
        $req->execute();
        $profileModel = $req->fetch();
        return new profileDetailsModel($profileModel);
    }

    //This updates or creates a new entry for the profile table
    public static function insertProfileDetails($profileController, $type){
        $profileID = intval($profileController->getProfileID());
        $age = intval($profileController->getAge());
        $gender = $profileController->getGender();
        $keyAchievement1 = $profileController->getKeyAchievement1();
        $keyAchievement2 = $profileController->getKeyAchievement2();
        $keyAchievement3 = $profileController->getKeyAchievement3();
        $keyAchievement4 = $profileController->getKeyAchievement4();
        $favouriteGod = $profileController->getFavouriteGod();
        $country = $profileController->getCountry();
        $mainGames = intval($profileController->getMainGames());
        $speedGames  = intval($profileController->getSpeedGames());
        $bio = $profileController->getBio();
        $achievements = json_encode($profileController->getAchievements());
        $achievementsSolo = json_encode($profileController->getAchievementsSolo());
        $uploadSecurity = $profileController->getUploadSecurity();
        $soloLeaderboard = intval($profileController->getSoloLeaderboard());
        $teamLeaderboard = intval($profileController->getTeamLeaderboard());
        $fullLeaderboard = intval($profileController->getFullLeaderboard());
        $db = db_conx::getInstance();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO profileDetails (profileID, age, gender, keyAchievement1, keyAchievement2, keyAchievement3, keyAchievement4, favouriteGod, country, mainGames, speedGames, bio, achievements, achievementsSolo, uploadSecurity, soloLeaderboard, teamLeaderboard, fullLeaderboard) VALUES (:profileID, :age, :gender, :keyAchievement1, :keyAchievement2, :keyAchievement3, :keyAchievement4, :favouriteGod, :country, :mainGames, :speedGames, :bio, :achievements, :achievementsSolo, :uploadSecurity, :soloLeaderboard, :teamLeaderboard, :fullLeaderboard)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE profileDetails SET age= :age, gender= :gender, keyAchievement1= :keyAchievement1, keyAchievement2= :keyAchievement2, keyAchievement3= :keyAchievement3, keyAchievement4= :keyAchievement4, favouriteGod= :favouriteGod, country= :country, mainGames= :mainGames, speedGames= :speedGames, bio= :bio, achievements= :achievements, achievementsSolo= :achievementsSolo, uploadSecurity= :uploadSecurity, soloLeaderboard= :soloLeaderboard, teamLeaderboard= :teamLeaderboard, fullLeaderboard= :fullLeaderboard WHERE profileID= :profileID");
        }
        $req->bindParam(':profileID', $profileID);
        $req->bindParam(':age', $age);
        $req->bindParam(':gender', $gender);
        $req->bindParam(':keyAchievement1', $keyAchievement1);
        $req->bindParam(':keyAchievement2', $keyAchievement2);
        $req->bindParam(':keyAchievement3', $keyAchievement3);
        $req->bindParam(':keyAchievement4', $keyAchievement4);
        $req->bindParam(':favouriteGod', $favouriteGod);
        $req->bindParam(':country', $country);
        $req->bindParam(':mainGames', $mainGames);
        $req->bindParam(':speedGames', $speedGames);
        $req->bindParam(':bio', $bio);
        $req->bindParam(':achievements', $achievements);
        $req->bindParam(':achievementsSolo', $achievementsSolo);
        $req->bindParam(':uploadSecurity', $uploadSecurity);
        $req->bindParam(':soloLeaderboard', $soloLeaderboard);
        $req->bindParam(':teamLeaderboard', $teamLeaderboard);
        $req->bindParam(':fullLeaderboard', $fullLeaderboard);
        $req->execute();
    }


    //This function finds a profile by player name
    public static function getProfileAccountType($accountTypeID) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT value FROM AccountType WHERE rank= :accountType LIMIT 1');
        $req->bindParam(':accountType', $accountTypeID);
        $req->execute();
        $profileModel = $req->fetch();
        return $profileModel['value'];
    }


    //This function finds a profile by player name
    public static function getAllProfiles() {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM profileDetails');
        $req->execute();
        $profileModel = $req->fetchAll();
        return $profileModel;
    }

    public static function getAllShrineScores($type){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT profileDetails.profileID, profileDetails.'.$type.', Profile.profileName, Profile.profilePicture FROM profileDetails INNER JOIN Profile ON profileDetails.profileID = Profile.id ORDER BY profileDetails.'.$type.' DESC');
        $req->execute();
        $profileModel = $req->fetchAll();
        return $profileModel;

    }


}