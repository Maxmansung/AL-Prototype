<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class avatarModel extends avatar
{
    private function __construct($avatarModel)
    {
        $this->avatarID = intval($avatarModel['avatarID']);
        $this->profileID = $avatarModel['profileID'];
        $this->mapID = intval($avatarModel['mapID']);
        $this->stamina = intval($avatarModel['stamina']);
        $this->zoneID = intval($avatarModel['zoneID']);
        $this->inventory = json_decode($avatarModel['inventory']);
        $this->partyID = intval($avatarModel['partyID']);
        $this->readiness = $avatarModel['readiness'];
        if (is_object(json_decode($avatarModel['avatarTempRecord']))) {
            $this->avatarTempRecord = get_object_vars(json_decode($avatarModel['avatarTempRecord']));
        } else {
            $this->avatarTempRecord = array();
        }
        if (is_object(json_decode($avatarModel['achievements']))) {
            $this->achievements = get_object_vars(json_decode($avatarModel['achievements']));
        } else {
            $this->achievements = array();
        }
        if (is_object(json_decode($avatarModel['partyVote']))) {
            $this->partyVote = get_object_vars(json_decode($avatarModel['partyVote']));
        } else {
            $this->partyVote = array();
        }
        $this->researchStats = (json_decode($avatarModel['researchStats']));
        $this->researched = (json_decode($avatarModel['researched']));
        $this->tempModLevel = intval($avatarModel['tempModLevel']);
        $this->findingChanceMod = 0;
        $this->findingChanceFail = intval($avatarModel['findingChanceFail']);
        if (is_object(json_decode($avatarModel['shrineScore']))) {
            $this->shrineScore = get_object_vars(json_decode($avatarModel['shrineScore']));
        } else {
            $this->shrineScore = array();
        }
        $this->forumPosts = json_decode($avatarModel['forumPosts']);
        if (is_object(json_decode($avatarModel['statusArray']))) {
            $this->statusArray = get_object_vars(json_decode($avatarModel['statusArray']));
        } else {
            $this->statusArray = array();
        }
        $this->avatarImage = $avatarModel['avatarImage'];
        $this->favourSolo = $avatarModel['favourSolo'];
        $this->favourTeam = $avatarModel['favourTeam'];
        $this->favourMap = $avatarModel['favourMap'];
        $this->currentFavour = json_decode($avatarModel['currentFavour']);
    }

    public static function findAvatarID($avatarID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Avatar WHERE avatarID= :avatarID LIMIT 1');
        $req->execute(array('avatarID' => $avatarID));
        $avatarModel = $req->fetch();
        return new avatarModel($avatarModel);

    }

    public static function insertAvatar($controller, $type){
        $db = db_conx::getInstance();
        $avatarID = intval($controller->getAvatarID());
        $profileID = $controller->getProfileID();
        $mapID = intval($controller->getMapID());
        $stamina = $controller->getStamina();
        $zoneID = intval($controller->getZoneID());
        $inventory = json_encode($controller->getInventory());
        $partyID = intval($controller->getPartyID());
        $readiness = $controller->getReady();
        $avatarTempRecord = json_encode($controller->getavatarTempRecord());
        $achievements = json_encode($controller->getachievements());
        $partyVote = json_encode($controller->getPartyVote());
        $researchStats = json_encode($controller->getResearchStats());
        $researched = json_encode($controller->getResearched());
        $tempModLevel = $controller->getTempModLevel();
        $findingChanceFail = $controller->getFindingChanceFail();
        $shrineScore = json_encode($controller->getShrineScore());
        $forumPosts = json_encode($controller->getForumPosts());
        $statusArray = json_encode($controller->getStatusArray());
        $avatarImage = $controller->getAvatarImage();
        $favourSolo = intval($controller->getFavourSolo());
        $favourTeam = intval($controller->getFavourTeam());
        $favourMap = intval($controller->getFavourMap());
        $currentFavour = json_encode($controller->getCurrentFavour());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Avatar (profileID, mapID, stamina, zoneID, inventory, partyID, readiness, avatarTempRecord, achievements, partyVote, researchStats, researched, tempModLevel, findingChanceFail, shrineScore, forumPosts, statusArray,avatarImage, favourSolo, favourTeam, favourMap,currentFavour) VALUES (:profileID, :mapID, :stamina, :zoneID, :inventory, :partyID, :readiness, :avatarTempRecord, :achievements, :partyVote, :researchStats, :researched, :tempModLevel, :findingChanceFail, :shrineScore, :forumPosts, :statusArray, :avatarImage,:favourSolo, :favourTeam, :favourMap,:currentFavour)");
        } elseif ($type == "Update") {
            $req = $db->prepare("UPDATE Avatar SET profileID= :profileID, mapID= :mapID, stamina= :stamina, zoneID = :zoneID, inventory= :inventory, partyID= :partyID, readiness= :readiness, avatarTempRecord= :avatarTempRecord, achievements= :achievements, partyVote= :partyVote, researchStats= :researchStats, researched= :researched, tempModLevel= :tempModLevel, findingChanceFail= :findingChanceFail, shrineScore= :shrineScore, forumPosts= :forumPosts, statusArray= :statusArray, avatarImage= :avatarImage, favourSolo= :favourSolo, favourTeam= :favourTeam, favourMap= :favourMap, currentFavour= :currentFavour WHERE avatarID= :avatarID");
            $req->bindParam(':avatarID', $avatarID);
        }
        $req->bindParam(':profileID', $profileID);
        $req->bindParam(':mapID', $mapID);
        $req->bindParam(':stamina', $stamina);
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':inventory', $inventory);
        $req->bindParam(':partyID', $partyID);
        $req->bindParam(':readiness', $readiness);
        $req->bindParam(':avatarTempRecord', $avatarTempRecord);
        $req->bindParam(':achievements', $achievements);
        $req->bindParam(':partyVote', $partyVote);
        $req->bindParam(':researchStats', $researchStats);
        $req->bindParam(':researched', $researched);
        $req->bindParam(':tempModLevel', $tempModLevel);
        $req->bindParam(':findingChanceFail', $findingChanceFail);
        $req->bindParam(':shrineScore', $shrineScore);
        $req->bindParam(':forumPosts', $forumPosts);
        $req->bindParam(':statusArray', $statusArray);
        $req->bindParam(':avatarImage', $avatarImage);
        $req->bindParam(':favourSolo', $favourSolo);
        $req->bindParam(':favourTeam', $favourTeam);
        $req->bindParam(':favourMap', $favourMap);
        $req->bindParam(':currentFavour', $currentFavour);
        $req->execute();
        if ($type == "Insert"){
            $check = intval($db->lastInsertId());
            return $check;
        }
    }

    public static function deleteAvatar($avatarID){
        $db = db_conx::getInstance();
        $req = $db->prepare('DELETE FROM Avatar WHERE avatarID= :avatarID LIMIT 1');
        $req->execute(array('avatarID' => $avatarID));
        $avatarModel = $req->fetch();
        return new avatarModel($avatarModel);

    }

    public static function getAllMapAvatars($mapID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Avatar WHERE mapID= :mapID');
        $req->execute(array('mapID' => $mapID));
        $avatarList = $req->fetchAll();;
        $avatarArray = [];
        foreach ($avatarList as $avatar) {
            $tempID = $avatar["avatarID"];
            $avatarArray[$tempID] = new avatarModel($avatar);
        }
        return $avatarArray;
    }


    public static function getAllPartyAvatars($partyID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Avatar WHERE partyID= :partyID');
        $req->execute(array('partyID' => $partyID));
        $avatarList = $req->fetchAll();;
        $avatarArray = [];
        foreach ($avatarList as $avatar) {
            $tempID = $avatar["avatarID"];
            $avatarArray[$tempID] = new avatarModel($avatar);
        }
        return $avatarArray;
    }


    public static function getAvatarsInArray($array){
        $db = db_conx::getInstance();
        $cleanArray = "(";
        $cleanArray .= implode(",",$array);
        $cleanArray .= ")";
        $req = $db->prepare('SELECT * FROM Avatar WHERE avatarID IN '.$cleanArray);
        $req->execute();
        $avatarList = $req->fetchAll();;
        $avatarArray = [];
        foreach ($avatarList as $avatar) {
            $tempID = $avatar["avatarID"];
            $avatarArray[$tempID] = new avatarModel($avatar);
        }
        return $avatarArray;
    }

    public static function resetShrineRewards($mapID){
        $db = db_conx::getInstance();
        $var = json_encode(array());
        $req = $db->prepare('UPDATE Avatar SET currentFavour= :favour WHERE mapID= :mapID');
        $req->bindParam(':favour', $var);
        $req->bindParam(':mapID', $mapID);
        $req->execute();
    }

}