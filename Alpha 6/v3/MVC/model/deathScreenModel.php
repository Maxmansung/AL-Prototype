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
        if (is_object(json_decode($deathModel['deathStatistics']))) {
            $this->deathStatistics = get_object_vars(json_decode($deathModel['deathStatistics']));
        }
        if (is_object(json_decode($deathModel['deathAchievements']))) {
            $this->deathAchievements = get_object_vars(json_decode($deathModel['deathAchievements']));
        }
        $this->gameType = $deathModel['gameType'];
        if (is_object(json_decode($deathModel['shrineScore']))) {
            $this->shrineScore = get_object_vars(json_decode($deathModel['shrineScore']));
        }
        $this->deathType = intval($deathModel['deathType']);
        $this->partyPlayersLeft = intval($deathModel['partyPlayersLeft']);
        $this->dayDuration = $deathModel['dayDuration'];
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
        $deathStatistics = json_encode($deathScreenController->getDeathStatistics());
        $deathAchievements = json_encode($deathScreenController->getDeathAchievements());
        $gameType = $deathScreenController->getGameType();
        $shrineScore = json_encode($deathScreenController->getShrineScore());
        $deathType = $deathScreenController->getDeathType();
        $partyPlayersLeft = $deathScreenController->getPartyPlayersLeft();
        $dayDuration = $deathScreenController->getDayDuration();
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO DeathScreen (profileID, mapID, partyName, deathDay, nightTemp, survivableTemp, deathStatistics, deathAchievements, gameType, shrineScore, deathType, partyPlayersLeft, dayDuration) VALUES (:profileID, :mapID, :partyName, :deathDay, :nightTemp, :survivableTemp, :deathStatistics, :deathAchievements, :gameType, :shrineScore, :deathType, :partyPlayersLeft, :dayDuration)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE DeathScreen SET mapID= :mapID, partyName= :partyName, deathDay= :deathDay, nightTemp= :nightTemp, survivableTemp= :survivableTemp, deathStatistics= :deathStatistics, deathAchievements= :deathAchievements, gameType= :gameType, shrineScore= :shrineScore, deathType= :deathType, partyPlayersLeft= :partyPlayersLeft, dayDuration= :dayDuration WHERE profileID= :profileID");
        }
        $req->bindParam(':profileID', $profileID);
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':partyName', $partyName);
        $req->bindParam(':deathDay', $deathDay);
        $req->bindParam(':nightTemp', $nightTemp);
        $req->bindParam(':survivableTemp', $survivableTemp);
        $req->bindParam(':deathStatistics', $deathStatistics);
        $req->bindParam(':deathAchievements', $deathAchievements);
        $req->bindParam(':gameType', $gameType);
        $req->bindParam(':shrineScore', $shrineScore);
        $req->bindParam(':deathType', $deathType);
        $req->bindParam(':partyPlayersLeft', $partyPlayersLeft);
        $req->bindParam(':dayDuration', $dayDuration);
        $req->execute();
    }

    public static function deleteDeathScreen($profileID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM DeathScreen WHERE profileID= :profileID LIMIT 1');
        $req->execute(array('profileID' => $profileID));
        return "Success";

    }

}