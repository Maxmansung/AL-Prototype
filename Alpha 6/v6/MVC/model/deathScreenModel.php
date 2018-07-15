<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class deathScreenModel extends deathScreen
{

    private function __construct($deathModel)
    {
        $this->profileID = intval($deathModel['profileID']);
        $this->mapID = $deathModel['mapID'];
        $this->partyName = $deathModel['partyName'];
        $this->deathDay = intval($deathModel['deathDay']);
        $this->nightTemp = intval($deathModel['nightTemp']);
        $this->survivableTemp = intval($deathModel['survivableTemp']);
        if (is_object(json_decode($deathModel['deathAchievements']))) {
            $this->deathAchievements = get_object_vars(json_decode($deathModel['deathAchievements']));
        }
        $this->gameType = $deathModel['gameType'];
        $this->deathType = intval($deathModel['deathType']);
        $this->dayDuration = $deathModel['dayDuration'];
        $this->favourSolo = intval($deathModel['favourSolo']);
        $this->favourTeam = intval($deathModel['favourTeam']);
        $this->favourMap = intval($deathModel['favourMap']);
    }

    public static function getDeathScreen($profileID) {
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM DeathScreen WHERE profileID= :profileID LIMIT 1');
        $req->execute(array('profileID' => $profileID));
        $deathModel = $req->fetch();

        return new deathScreenModel($deathModel);
    }

    public static function insertDeathScreen($deathScreenController, $type){
        $db = db_conx::getInstance();
        $profileID = intval($deathScreenController->getProfileID());
        $mapID = $deathScreenController->getMapID();
        $partyName = $deathScreenController->getPartyName();
        $deathDay = intval($deathScreenController->getDeathDay());
        $nightTemp = intval($deathScreenController->getNightTemp());
        $survivableTemp = intval($deathScreenController->getSurvivableTemp());
        $deathAchievements = json_encode($deathScreenController->getDeathAchievements());
        $gameType = intval($deathScreenController->getGameType());
        $deathType = intval($deathScreenController->getDeathType());
        $dayDuration = $deathScreenController->getDayDuration();
        $favourSolo = intval($deathScreenController->getFavourSolo());
        $favourTeam = intval($deathScreenController->getFavourTeam());
        $favourMap = intval($deathScreenController->getFavourMap());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO DeathScreen (profileID, mapID, partyName, deathDay, nightTemp, survivableTemp, deathAchievements, gameType, deathType, dayDuration, favourSolo, favourTeam, favourMap) VALUES (:profileID, :mapID, :partyName, :deathDay, :nightTemp, :survivableTemp, :deathAchievements, :gameType, :deathType, :dayDuration, :favourSolo, :favourTeam, :favourMap)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE DeathScreen SET mapID= :mapID, partyName= :partyName, deathDay= :deathDay, nightTemp= :nightTemp, survivableTemp= :survivableTemp, deathAchievements= :deathAchievements, gameType= :gameType, deathType= :deathType, dayDuration= :dayDuration, favourSolo= :favourSolo, favourTeam= :favourTeam, favourMap= :favourMap WHERE profileID= :profileID");
        }
        $req->bindParam(':profileID', $profileID);
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':partyName', $partyName);
        $req->bindParam(':deathDay', $deathDay);
        $req->bindParam(':nightTemp', $nightTemp);
        $req->bindParam(':survivableTemp', $survivableTemp);
        $req->bindParam(':deathAchievements', $deathAchievements);
        $req->bindParam(':gameType', $gameType);
        $req->bindParam(':deathType', $deathType);
        $req->bindParam(':dayDuration', $dayDuration);
        $req->bindParam(':favourSolo', $favourSolo);
        $req->bindParam(':favourTeam', $favourTeam);
        $req->bindParam(':favourMap', $favourMap);
        $req->execute();
    }

    public static function deleteDeathScreen($profileID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM DeathScreen WHERE profileID= :profileID LIMIT 1');
        $req->execute(array('profileID' => $profileID));
        return "Success";

    }

}