<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class partyZonePlayerController
{

    protected $isPlayer;
    protected $avatarName;
    protected $avatarID;
    protected $avatarParty;
    protected $avatarX;
    protected $avatarY;
    protected $avatarAlive;
    protected $readyStat;
    protected $inPlayerZone;
    protected $inParty;
    protected $invitingPlayer;
    protected $kickingPlayer;
    protected $votingChoice;
    protected $awaitingInvite;
    protected $avatarPartyID;
    protected $requestPending;

    function getAvatarID(){
        return $this->avatarID;
    }

    function getAvatarName(){
        return $this->avatarName;
    }


    function returnVars(){
        return get_object_vars($this);
    }

    private function __construct($avatarModel,$groupModel,$alive,$known,$ingroup,$isPlayer,$inZone,$inviting,$kicking,$votingChoice,$awaitingInvite,$pendingRequest,$partyKnown)
    {
        $this->avatarAlive = $alive;
        $this->isPlayer = $isPlayer;
        if ($alive === true) {
            $this->readyStat = $avatarModel->getReady();
            $this->avatarPartyID = $avatarModel->getPartyID();
            if ($partyKnown === true){
                $this->avatarParty = $groupModel->getPartyName();
            }
            if ($known === true) {
                $this->inPlayerZone = $inZone;
                $this->invitingPlayer = $inviting;
                $this->kickingPlayer = $kicking;
                $this->awaitingInvite = $awaitingInvite;
                $this->inParty = false;
                $this->avatarName = $avatarModel->getProfileID();
                $this->avatarID = $avatarModel->getAvatarID();
                if ($ingroup === true) {
                    $this->inParty = true;
                    $avatarZone = new zoneController($avatarModel->getZoneID());
                    $this->avatarX = $avatarZone->getCoordinateX();
                    $this->avatarY = $avatarZone->getCoordinateY();
                    $this->votingChoice = $votingChoice;
                    if ($this->isPlayer == true){
                        $this->requestPending = $pendingRequest;
                    }
                }
            }
        } else {
            $this->avatarName = $avatarModel->getProfileID();
        }
    }


    ////////////CONTROLLER FUNCTIONS///////////


    //This function checks if a player has favour with a god that will be lost by leaving the current party
    public static function checkTeamFavour($avatarID){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $party = new partyController($avatar->getPartyID());
        $shrineTeam = new shrineTeam();
        if (count($party->getMembers())===$shrineTeam->getMinPlayers()){
            $check = shrineActionsController::checkFavour($avatar->getPartyID(),$map->getCurrentDay(),2);
            if ($check === true) {
                return array("ALERT" => 34, "DATA" => "");
            }
        }
        return self::leaveParty($avatarID);
    }

    //This function causes a player to leave their current party
    public static function leaveParty($avatarID){
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        if (count($party->getMembers())<=1){
            //Player is alone in the group
            return array("ERROR" => 18);
        } else{
            if (in_array($avatar->getAvatarID(),$party->getMembers()) === false){
                //Player is not in the correct party
                return array("ERROR" => 19);
            } else{
                $newParty = partyController::getEmptyParty($avatar->getMapID());
                $newParty->setZoneExploration($party->getZoneExploration());
                $newParty->setPlayersKnown($party->getPlayersKnown());
                $newParty->addMember($avatar->getAvatarID());
                $party->removeMember($avatar->getAvatarID());
                $avatar->setPartyID($newParty->getPartyID());
                $newParty->uploadParty();
                $party->uploadParty();
                $avatar->updateAvatar();
                $map = new mapController($avatar->getMapID());
                $shrineTeam = new shrineTeam();
                if (count($party->getMembers()) < $shrineTeam->getMinPlayers()){
                    shrineActionsController::deleteTeamFavour($party->getPartyID(),$map->getCurrentDay());
                }
                chatlogGroupController::leaveGroup($avatar,$party->getPartyID(),$map->getCurrentDay());
                return array("ALERT"=>30,"DATA"=>$party->getPartyName());
            }
        }
    }

    //This function checks if a player has favour with a god that will be lost by joining a new party
    public static function checkSoloFavour($avatarID,$playerID){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $check = shrineActionsController::checkFavour($avatarID,$map->getCurrentDay(),1);
        $party = new partyController($avatar->getPartyID());
        $shrineTeam = new shrineTeam();
        if (count($party->getMembers())>=$shrineTeam->getMinPlayers()){
            return array("ERROR"=>68);
        } else {
            if ($check === true) {
                return array("ALERT" => 33, "DATA" => $playerID);
            } else {
                return self::joinParty($avatarID, $playerID);
            }
        }
    }

    //This function adds a request to join a specific party
    public static function joinParty($avatarID,$playerID){
        $playerIDClean = preg_replace(data::$cleanPatterns['num'],"",$playerID);
        $otherPlayer = new avatarController($playerIDClean);
        if ($otherPlayer->getAvatarID() != $playerIDClean || $playerIDClean == ""){
            return array("ERROR" => 20);
        } else {
            $newParty = new partyController($otherPlayer->getPartyID());
            $newPlayer= new avatarController($avatarID);
            if (in_array($newPlayer->getAvatarID(), $newParty->getMembers()) === true) {
                return array("ERROR" => 21);
            } if (partyModel::findPendingRequests($otherPlayer->getMapID(),$newPlayer->getAvatarID()) == true){
                $party = partyModel::findPendingRequestsItem($otherPlayer->getMapID(),$newPlayer->getAvatarID());
                return array("ALERT"=> 29,"DATA"=>array("current"=>$party->getPartyName(),"joining"=>$newParty->getPartyName(),"id"=>$otherPlayer->getAvatarID()));
            } else {
                if ($newPlayer->getAvatarID() != "") {
                    $newParty->addPendingRequests($newPlayer->getAvatarID());
                    $newParty->uploadParty();
                    $map = new mapController($otherPlayer->getMapID());
                    chatlogGroupController::playerJoining($newPlayer, $newParty->getPartyID(),$map->getCurrentDay());
                    return array("SUCCESS" => true);
                } else {
                    return array("ERROR"=>"Somehow you are not logged in when requesting to join");
                }
            }
        }
    }

    //This function adds a request to join a specific party
    public static function joinPartyOverride($avatarID,$playerID){
        $response = self::cancelJoin($avatarID);
        if (!key_exists("ERROR",$response)){
            return self::joinParty($avatarID,$playerID);
        } else {
            return $response;
        }
    }

    //This function adds a vote to kick a player from the party
    public static function kickPlayer($avatarID,$playerID){
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $votedPlayer = new avatarController($playerID);
        if (in_array($votedPlayer->getAvatarID(),$party->getMembers()) != true){
            return array("ERROR" => 24);
        } else {
            $party->addPendingBans($votedPlayer->getAvatarID());
            $party->uploadParty();
            $map = new mapController($votedPlayer->getMapID());
            chatlogGroupController::playerKicking($votedPlayer,$party->getPartyID(),$map->getCurrentDay());
            $response = self::votingOnPlayer($avatar->getAvatarID(),$votedPlayer->getAvatarID(),"accept");
            return $response;
        }
    }

    //This function applies the players vote regarding another player
    public static function votingOnPlayer($avatarID,$playerID,$type){
        $avatar = new avatarController($avatarID);
        $votedPlayer = new avatarController($playerID);
        $exists = false;
        foreach ($avatar->getPartyVote() as $player=>$vote){
            if ($votedPlayer->getAvatarID() == $player){
                $exists = true;
            }
        }
        if ($exists != true){
            return array("ERROR" => 22);
        } else {
            if ($type == "accept") {
                $avatar->changePartyVote($votedPlayer->getAvatarID(), 1);
            } elseif ($type == "reject"){
                $avatar->changePartyVote($votedPlayer->getAvatarID(), 2);
            } else {
                return array("ERROR" => 23);
            }
            $test = self::checkVotes($avatar->getPartyID(),$votedPlayer,$type,$avatarID);
            if (array_key_exists("SUCCESS",$test)) {
                $avatar->updateAvatar();
                $checkingVotes = self::calculateVotes($avatar->getPartyID(), $votedPlayer);
            } else {
                $checkingVotes = $test;
            }
            return $checkingVotes;
        }
    }

    //This function applies the players vote regarding another player
    public static function votingOnPlayerFinal($avatarID,$playerID,$type){
        $avatar = new avatarController($avatarID);
        $votedPlayer = new avatarController($playerID);
        $exists = false;
        foreach ($avatar->getPartyVote() as $player=>$vote){
            if ($votedPlayer->getAvatarID() == $player){
                $exists = true;
            }
        }
        if ($exists != true){
            return array("ERROR" => 22);
        } else {
            if ($type == "accept") {
                $avatar->changePartyVote($votedPlayer->getAvatarID(), 1);
            } elseif ($type == "reject"){
                $avatar->changePartyVote($votedPlayer->getAvatarID(), 2);
            } else {
                return array("ERROR" => 23);
            }
            $avatar->updateAvatar();
            $checkingVotes = self::calculateVotes($avatar->getPartyID(), $votedPlayer);
            return $checkingVotes;
        }
    }

    //This functions calculates if a player will join or be rejected from a group from the posted votes
    private static function checkVotes($partyID,$votedOn,$type,$avatarID)
    {
        $party = new partyController($partyID);
        $voters = $party->getMembers();
        $total = count($voters);
        $votesFor = 0;
        $sixty = $total * 0.599;
        foreach ($voters as $player) {
            $currentPlayer = new avatarController($player);
            $playersVotes = $currentPlayer->getPartyVote();
            if ($type === "accept") {
                if ($playersVotes[$votedOn->getAvatarID()] == 1 || $currentPlayer->getAvatarID() === $avatarID) {
                    $votesFor++;
                    if ($votesFor > $sixty) {
                        if ($votedOn->getPartyID() === $party->getPartyID()) {
                            $shrineTeam = new shrineTeam();
                            if (count($party->getMembers()) === $shrineTeam->getMinPlayers()) {
                                return array("ALERT" => 35, "DATA" => "".$votedOn->getAvatarID());
                            }
                            $shrineSolo = new shrineSolo();
                            if (count($party->getMembers()) === $shrineSolo->getMinPlayers()) {
                                return array("ALERT" => 36, "DATA" => "".$votedOn->getAvatarID());
                            }
                        } else {
                            $shrineTeam = new shrineTeam();
                            if (count($party->getMembers()) === $shrineTeam->getMaxPlayers()) {
                                return array("ALERT" => 35, "DATA" => "".$votedOn->getAvatarID());
                            }
                            $shrineSolo = new shrineSolo();
                            if (count($party->getMembers()) === $shrineSolo->getMaxPlayers()) {
                                return array("ALERT" => 36, "DATA" => "".$votedOn->getAvatarID());
                            }
                        }
                    }
                }
            }
        }
        return array("SUCCESS"=>true);
    }



    //This functions calculates if a player will join or be rejected from a group from the posted votes
    private static function calculateVotes($partyID,$votedOn)
    {
        $party = new partyController($partyID);
        $voters = $party->getMembers();
        $total = count($voters);
        $votesFor = 0;
        $votesAgainst = 0;
        $sixty = $total * 0.599;
        $forty = $total * 0.401;
        foreach ($voters as $player) {
            $currentPlayer = new avatarController($player);
            $playersVotes = $currentPlayer->getPartyVote();
            if ($playersVotes[$votedOn->getAvatarID()] == 1) {
                $votesFor++;
                if ($votesFor > $sixty) {
                    if ($votedOn->getPartyID() === $party->getPartyID()) {
                        return self::completeKickPlayer($party,$votedOn);
                    } else {
                        return self::acceptPlayerParty($party, $votedOn);
                    }
                }
            }
            elseif ($playersVotes[$votedOn->getAvatarID()] == 2) {
                $votesAgainst++;
                if ($votesAgainst > $forty) {
                    if ($votedOn->getPartyID() === $party->getPartyID()) {
                        return self::completeRejectKickPlayer($party,$votedOn);
                    } else {
                        return self::rejectPlayerParty($party, $votedOn);
                    }
                }
            }
        }
        return array("ALERT"=>31,"DATA"=>"Your vote has been taken into consideration, more votes are needed for a decision to be made though");
    }

    //This function kicks a player from the party
    private static function completeKickPlayer($party, $avatar)
    {
        $map = new mapController($avatar->getMapID());
        chatlogGroupController::kickSuccess($avatar,$avatar->getPartyID(),$map->getCurrentDay());
        $newParty = partyController::getEmptyParty($avatar->getMapID());
        $newParty->setZoneExploration($party->getZoneExploration());
        $newParty->setPlayersKnown($party->getPlayersKnown());
        $newParty->addMember($avatar->getAvatarID());
        $party->removeMember($avatar->getAvatarID());
        $shrineTeam = new shrineTeam();
        if (count($party->getMembers()) < $shrineTeam->getMinPlayers()){
            shrineActionsController::deleteTeamFavour($avatar->getPartyID(),$map->getCurrentDay());
        }
        $party->removePendingBans($avatar->getAvatarID());
        self::removeMapVotes($avatar);
        $avatar->clearVotes();
        $avatar->setPartyID($newParty->getPartyID());
        $newParty->uploadParty();
        $avatar->updateAvatar();
        partyController::removeAllInvites($avatar->getAvatarID(),$map->getCurrentDay());
        if (count($newParty->getMembers())< 3){
            $party = self::resetGroupVotes($party);
        }
        $party->uploadParty();
        return array("ALERT"=>31,"DATA"=>$avatar->getProfileID()." has been kicked from the party");
    }

    private static function resetGroupVotes($party){
        $party->setPendingBans(array());
        $avatars = avatarController::getAvatarsInArray($party->getMembers(),true);
        foreach ($avatars as $single){
            $single->clearVotes();
            $single->updateAvatar();
        }
        return $party;
    }

    //This functions rejects kicking a player from the party
    private static function completeRejectKickPlayer($party,$avatar){
        $map = new mapController($avatar->getMapID());
        chatlogGroupController::kickFail($avatar,$avatar->getPartyID(),$map->getCurrentDay());
        $party->removePendingBans($avatar->getAvatarID());
        self::removeMapVotes($avatar);
        $party->uploadParty();
        return array("ALERT"=>31,"DATA"=>$avatar->getProfileID()." is not being kicked from the party");
    }

    //This function transfers a player into a new party
    private static function acceptPlayerParty($newParty,$avatar){
        $oldParty = new partyController($avatar->getPartyID());
        $map = new mapController($avatar->getMapID());
        chatlogGroupController::joinSuccess($avatar,$newParty->getPartyID(),$map->getCurrentDay());
        $newParty->addMember($avatar->getAvatarID());
        $newParty->removePendingRequests($avatar->getAvatarID());
        $newParty->combinePlayersKnown($oldParty->getPlayersKnown());
        $newParty->combineZoneExploration($oldParty->getZoneExploration());
        self::removeMapVotes($avatar);
        $oldParty->removeMember($avatar->getAvatarID());
        $shrineSolo = new shrineSolo();
        if (count($newParty->getMembers())> $shrineSolo->getMaxPlayers()){
            $soloMember = $newParty->getMembers();
            foreach ($soloMember as $tempAvatar)
                shrineActionsController::deleteSoloFavour($tempAvatar,$map->getCurrentDay());
        }
        $shrineTeam = new shrineTeam();
        if (count($oldParty->getMembers()) > $shrineTeam->getMaxPlayers()){
            shrineActionsController::deleteTeamFavour($avatar->getPartyID(),$map->getCurrentDay());
        }
        if (count($oldParty->getMembers()) < 1){
            $oldParty->emptyParty();
        }
        $avatar->setPartyID($newParty->getPartyID());
        $avatar->clearVotes();
        $oldParty->uploadParty();
        $newParty->uploadParty();
        $avatar->updateAvatar();
        return array("ALERT"=>31,"DATA"=>$avatar->getProfileID()." has now joined the party");
    }

    //This function cancels a players request to join a party
    private static function rejectPlayerParty($party,$avatar){
        $party->removePendingRequests($avatar->getAvatarID());
        $map = new mapController($avatar->getMapID());
        chatlogGroupController::joinFail($avatar,$party->getPartyID(),$map->getCurrentDay());
        self::removeMapVotes($avatar);
        $party->uploadParty();
        return array("ALERT"=>31,"DATA"=>$avatar->getProfileID()." has failed to be accepted into the party");
    }

    //This resets the groups votes surrounding a player
    private static function removeMapVotes($playerVote)
    {
        $mapPlayers = avatarModel::getAllMapAvatars($playerVote->getMapID());
        foreach ($mapPlayers as $player) {
            $avatar = new avatarController($player);
            $avatar->changePartyVote($playerVote->getAvatarID(), 0);
            $avatar->updateAvatar();
        }
    }

    //This function changes the name of a players group
    public static function changeGroupName($avatarID,$name){
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $newName = preg_replace(data::$cleanPatterns['textSpace'],"",$name);
        if (count($party->getMembers())>1){
            return array("ERROR" => 25);
        } else {
            $checkDuplicate = partyController::findMatchingParty($avatar->getMapID(),$newName);
            if ($checkDuplicate === true){
                return array("ERROR" => 26);
            } else {
                if (strlen($newName)>20 || strlen($newName)<3){
                    return array("ERROR" => 27);
                } else {
                    $party->setPartyName($newName);
                    $party->uploadParty();
                    return array("ALERT"=>9,"DATA"=>"Your party name has now been changed");
                }
            }
        }
    }

    public static function cancelJoin($avatarID){
        $avatar = new avatarController($avatarID);
        $party = partyModel::findPendingRequestsItem($avatar->getMapID(),$avatar->getAvatarID());
        $newParty = new partyController($party);
        if ($newParty->getPartyID() == ""){
            return array("ERROR" => 20);
        } else {
            if (in_array($avatar->getAvatarID(), $newParty->getMembers()) === true) {
                return array("ERROR" => 21);
            } else {
                $newParty->removePendingRequests($avatar->getAvatarID());
                $newParty->uploadParty();
                $map = new mapController($avatar->getMapID());
                chatlogGroupController::cancelGroupRequest($avatar,$newParty->getPartyID(),$map->getCurrentDay());
                return array("SUCCESS"=>true);
            }
        }
    }

    static function getUnknownResearch($other,$self,$view)
    {
        $buildingList = buildingView::getAllBuildingsView();
        $knownList = $self->getResearched();
        $finalList = [];
        foreach ($knownList as $item){
            if (!in_array($item,$other->getResearched())) {
                if (in_array($buildingList[$item]->getBuildingsRequired(), $other->getResearched())) {
                    $building = $buildingList[$item];
                    if ($view === true) {
                        array_push($finalList, $building->returnVars());
                    } else {
                        array_push($finalList, $item);
                    }
                }
            }
        }
        return $finalList;
    }

    public static function teachPlayerResearch($avatarID,$playerID,$research)
    {
        $avatar = new avatarController($avatarID);
        if ($avatar->getStamina() < 2) {
            return array("ERROR" => 0);
        } else {
            $cleanResearch = preg_replace(data::$cleanPatterns['text'],"",$research);
            if (!in_array($cleanResearch, $avatar->getResearched())) {
                return array("ERROR" => 39);
            } else {
                $playerIDClean = preg_replace(data::$cleanPatterns['num'],"",$playerID);
                $otherPlayer = new avatarController($playerIDClean);
                if ($otherPlayer->getAvatarID() != $playerIDClean) {
                    return array("ERROR" => 48);
                } else {
                    if ($otherPlayer->getZoneID() !== $avatar->getZoneID()){
                        return array("ERROR"=>"Player is not in the correct zone to do this action");
                    } else {
                        $list = self::getUnknownResearch($otherPlayer, $avatar, false);
                        if (!in_array($research, $list)) {
                            return array("ERROR" => 49);
                        } else {
                            $avatar->useStamina(2);
                            $avatar->addPlayStatistics("research", 2);
                            $otherPlayer->addResearched($research);
                            $avatar->updateAvatar();
                            $otherPlayer->updateAvatar();
                            $building = buildingController::createBlankBuilding($cleanResearch);
                            $map = new mapController($avatar->getMapID());
                            chatlogPersonalController::teachPlayerResearch($avatar, $building->getName(), $otherPlayer->getProfileID(), $map->getCurrentDay());
                            return array("ALERT" => 17, "DATA" => array("player" => $otherPlayer->getProfileID(), "building" => $building->getName()));
                        }
                    }
                }
            }
        }
    }



        /////////////VIEW FUNCTIONS/////////////


    //This shows all of the players within the game
    public static function getPlayerDetails($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $currentAvatars = avatarController::getAllMapAvatars($avatar->getMapID(),false);
        $party = new partyController($avatar->getPartyID());
        $map = new mapController($avatar->getMapID());
        $avatarList = $map->getAvatars();
        $avatarsArray = [];
        $kickingList = $party->getPendingBans();
        $inviteList = $party->getPendingRequests();
        $counter = 0;
        foreach ($avatarList as $avatarSingle) {
            $known = false;
            $alive = false;
            $ingroup = false;
            $isPlayer = false;
            $inZone = false;
            $partyKnown = false;
            $awaitingInvite = false;
            $pendingRequest = false;
            $votingVision = [];
            $kicking = in_array($avatarSingle, $kickingList);
            $inviting = in_array($avatarSingle, $inviteList);
            if ($avatarSingle == $avatar->getAvatarID()) {
                $isPlayer = true;
                $pendingRequest = partyModel::findPendingRequests($map->getMapID(), $avatar->getAvatarID());
            }
            if (isset($currentAvatars[$avatarSingle])) {
                $avatarModel = $currentAvatars[$avatarSingle];
                $groupModel = new partyController($avatarModel->getPartyID());
                if ($currentAvatars[$avatarSingle]->getZoneID() === $avatar->getZoneID()) {
                    $inZone = true;
                    if (in_array($avatarSingle, $party->getPlayersKnown()) === false) {
                        $party->addPlayersKnown($avatarSingle);
                        $party->uploadParty();
                    }
                }
                if ($currentAvatars[$avatarSingle]->getPartyID() === $avatar->getPartyID()) {
                    $ingroup = true;
                    $votingChoice = $currentAvatars[$avatarSingle]->getPartyVote();
                    foreach ($votingChoice as $key => $vote) {
                        if (in_array($key, $party->getPlayersKnown()) === true) {
                            $votingVision[$key] = $vote;
                        }
                    }
                }
                foreach ($party->getPlayersKnown() as $player){
                    if ($currentAvatars[$player]->getPartyID() === $currentAvatars[$avatarSingle]->getPartyID()){
                        $partyKnown = true;
                    }
                }
                if (in_array($avatarSingle, $party->getPlayersKnown())) {
                    $known = true;
                }
                if ($avatarModel->getReady() != "dead") {
                    $alive = true;
                }
                $otherParty = new partyController($currentAvatars[$avatarSingle]->getPartyID());
                $otherPartyInvites = $otherParty->getPendingRequests();
                $awaitingInvite = in_array($avatar->getAvatarID(), $otherPartyInvites);
            } else {
                $avatarModel = str_replace($map->getMapID(), "", $avatarSingle);
                $groupModel = false;
            }
            $tempObject = new partyZonePlayerController($avatarModel, $groupModel, $alive, $known, $ingroup, $isPlayer, $inZone, $inviting, $kicking, $votingVision, $awaitingInvite, $pendingRequest, $partyKnown);
            $avatarsArray[$counter] = $tempObject->returnVars();
            $counter++;
        }
        $logs = chatlogGroupController::getAllGroupLogs($avatar->getPartyID(),$map->getCurrentDay(),$party->getPlayersKnown());
        $final= array("avatars"=>$avatarsArray,"logs"=>$logs);
        return $final;
    }

    public static function getSinglePlayerDetails($avatarID,$personalID)
    {
        $avatar = new avatarController($avatarID);
        $personal = new avatarController($personalID);
        $party = new partyController($personal->getPartyID());
        $otherParty = new partyController(($avatar->getPartyID()));
        $known = false;
        $alive = false;
        $ingroup = false;
        $isPlayer = false;
        $inZone = false;
        $partyKnown = false;
        $awaitingInvite = false;
        $pendingRequest = false;
        $votingVision = [];
        if ($personal->getAvatarID() == $avatar->getAvatarID()) {
            $isPlayer = true;
        }
        if ($personal->getPartyID() === $avatar->getPartyID()) {
            $ingroup = true;
        }
        if (in_array($avatar->getAvatarID(), $party->getPlayersKnown())) {
            $known = true;
        }
        if ($avatar->getAvatarID() != "dead") {
            $alive = true;
        }
        $controller = new partyZonePlayerController($avatar,$otherParty,$alive,$known,$ingroup,$isPlayer,$inZone,null,null,$votingVision,$awaitingInvite,$pendingRequest,$partyKnown);
        return $controller;

    }

}