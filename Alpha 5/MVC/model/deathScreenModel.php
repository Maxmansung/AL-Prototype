<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class deathScreenModel extends deathScreen
{

    private function __construct($deathModel)
    {
        $this->profileID = $deathModel['profileID'];
        $this->mapID = $deathModel['mapID'];
        $this->partyName = $deathModel['partyName'];
        $this->deathDay = $deathModel['deathDay'];
        $this->nightTemp = $deathModel['nightTemp'];
        $this->survivableTemp = $deathModel['survivableTemp'];
        $this->deathStatistics = get_object_vars(json_decode($deathModel['deathStatistics']));
        $this->deathAchievements = get_object_vars(json_decode($deathModel['deathAchievements']));
        $this->gameType = $deathModel['gameType'];
        $this->shrineScore = get_object_vars(json_decode($deathModel['shrineScore']));
        $this->deathType = intval($deathModel['deathType']);
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
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO DeathScreen (profileID, mapID, partyName, deathDay, nightTemp, survivableTemp, deathStatistics, deathAchievements, gameType, shrineScore, deathType) VALUES (:profileID, :mapID, :partyName, :deathDay, :nightTemp, :survivableTemp, :deathStatistics, :deathAchievements, :gameType, :shrineScore, :deathType)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE DeathScreen SET mapID= :mapID, partyName= :partyName, deathDay= :deathDay, nightTemp= :nightTemp, survivableTemp= :survivableTemp, deathStatistics= :deathStatistics, deathAchievements= :deathAchievements, gameType= :gameType, shrineScore= :shrineScore, deathType= :deathType WHERE profileID= :profileID");
        }
        $req->bindParam(':profileID', $deathScreenController->getProfileID());
        $req->bindParam(':mapID', $deathScreenController->getMapID());
        $req->bindParam(':partyName', $deathScreenController->getPartyName());
        $req->bindParam(':deathDay', $deathScreenController->getDeathDay());
        $req->bindParam(':nightTemp', $deathScreenController->getNightTemp());
        $req->bindParam(':survivableTemp', $deathScreenController->getSurvivableTemp());
        $req->bindParam(':deathStatistics', json_encode($deathScreenController->getDeathStatistics()));
        $req->bindParam(':deathAchievements', json_encode($deathScreenController->getDeathAchievements()));
        $req->bindParam(':gameType', $deathScreenController->getGameType());
        $req->bindParam(':shrineScore', json_encode($deathScreenController->getShrineScore()));
        $req->bindParam(':deathType', $deathScreenController->getDeathType());
        $req->execute();
    }

    public static function deleteDeathScreen($profileID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM DeathScreen WHERE profileID= :profileID LIMIT 1');
        $req->execute(array('profileID' => $profileID));
        return "Success";

    }

}