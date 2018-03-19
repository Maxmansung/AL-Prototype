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
                chatlogGroupController::leaveGroup($avatar->getAvatarID(),$party->getPartyID());
                return array("SUCCESS"=>true);
            }
        }
    }

    //This function adds a request to join a specific party
    public static function joinParty($avatarID,$playerID){
        $otherPlayer = new avatarController($playerID);
        if ($otherPlayer->getAvatarID() != $playerID || $playerID == ""){
            return array("ERROR" => 20);
        } else {
            $newParty = new partyController($otherPlayer->getPartyID());
            $newPlayer= new avatarController($avatarID);
            if (in_array($newPlayer->getAvatarID(), $newParty->getMembers()) === true) {
                return array("ERROR" => 21);
            } if (partyModel::findPendingRequests($otherPlayer->getMapID(),$newPlayer->getAvatarID()) == true){
                return array("ERROR"=> 54);
            } else {
                if ($newPlayer->getAvatarID() != "") {
                    $newParty->addPendingRequests($newPlayer->getAvatarID());
                    $newParty->uploadParty();
                    chatlogGroupController::playerJoining($avatarID, $newParty->getPartyID());
                    return array("SUCCESS" => true);
                } else {
                    return array("ERROR"=>"Somehow you are not logged in when requesting to join");
                }
            }
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
            chatlogGroupController::playerKicking($votedPlayer->getAvatarID(),$party->getPartyID());
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
            $avatar->updateAvatar();
            $checkingVotes = self::calculateVotes($avatar->getPartyID(),$votedPlayer->getAvatarID());
            return $checkingVotes;
        }
    }

    //This function empties a party when the last player leaves it
    private static function emptyParty($partyModel)
    {
        $partyModel->removeAllZoneExploration();
        $partyModel->setMembers(array());
        $partyModel->setPlayersKnown(array());
        $partyModel->setPendingBans(array());
        $partyModel->setPendingRequests(array());
        $partyName = str_replace($partyModel->getMapID(), "", $partyModel->getPartyID());
        $partyModel->setPartyName($partyName);
        chatlogGroupController::deleteGroupLogs($partyModel->getPartyID());
    }

    //This functions calculates if a player will join or be rejected from a group from the posted votes
    private static function calculateVotes($partyID,$playerVotedOn)
    {
        $party = new partyController($partyID);
        $votedOn = new avatarController($playerVotedOn);
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
                        return self::completeKickPlayer($votedOn->getAvatarID());
                    } else {
                        return self::acceptPlayerParty($party->getPartyID(), $votedOn->getAvatarID());
                    }
                }
            }
            elseif ($playersVotes[$votedOn->getAvatarID()] == 2) {
                $votesAgainst++;
                if ($votesAgainst > $forty) {
                    if ($votedOn->getPartyID() === $party->getPartyID()) {
                        return self::completeRejectKickPlayer($votedOn->getAvatarID());
                    } else {
                        return self::rejectPlayerParty($party->getPartyID(), $votedOn->getAvatarID());
                    }
                }
            }
        }
        return array("SUCCESS"=>"No changes");
    }

    //This function kicks a player from the party
    private static function completeKickPlayer($playerVotedOn)
    {
        $avatar = new avatarController($playerVotedOn);
        $party = new partyController($avatar->getPartyID());
        chatlogGroupController::kickSuccess($avatar->getAvatarID(),$avatar->getPartyID());
        $newParty = partyController::getEmptyParty($avatar->getMapID());
        $newParty->setZoneExploration($party->getZoneExploration());
        $newParty->setPlayersKnown($party->getPlayersKnown());
        $newParty->addMember($avatar->getAvatarID());
        $party->removeMember($avatar->getAvatarID());
        $party->removePendingBans($avatar->getAvatarID());
        $members = $party->getMembers();
        self::removeMapVotes($members,$avatar->getAvatarID());
        $avatar->setPartyID($newParty->getPartyID());
        $avatar->clearVotes();
        $newParty->uploadParty();
        $party->uploadParty();
        $avatar->updateAvatar();
        partyController::removeAllInvites($avatar->getAvatarID());
        return array("SUCCESS"=>true);
    }

    //This functions rejects kicking a player from the party
    private static function completeRejectKickPlayer($playerVotedOn){
        $avatar = new avatarController($playerVotedOn);
        $party = new partyController($avatar->getPartyID());
        chatlogGroupController::kickFail($avatar->getAvatarID(),$avatar->getPartyID());
        $party->removePendingBans($avatar->getAvatarID());
        $members = $party->getMembers();
        self::removePartyVotes($members,$avatar->getAvatarID());
        $party->uploadParty();
        return array("SUCCESS"=>true);
    }

    //This function transfers a player into a new party
    private static function acceptPlayerParty($partyID,$playerVotedOn){
        $avatar = new avatarController($playerVotedOn);
        $oldParty = new partyController($avatar->getPartyID());
        $newParty = new partyController($partyID);
        chatlogGroupController::joinSuccess($avatar->getAvatarID(),$newParty->getPartyID());
        $newParty->addMember($avatar->getAvatarID());
        $newParty->removePendingRequests($avatar->getAvatarID());
        $newParty->combinePlayersKnown($oldParty->getPlayersKnown());
        $newParty->combineZoneExploration($oldParty->getZoneExploration());
        $members = $newParty->getMembers();
        self::removeMapVotes($members,$avatar->getAvatarID());
        $oldParty->removeMember($avatar->getAvatarID());
        if (count($oldParty->getMembers())<= 0){
            self::emptyParty($oldParty);
        }
        $avatar->setPartyID($newParty->getPartyID());
        $avatar->clearVotes();
        $oldParty->uploadParty();
        $newParty->uploadParty();
        $avatar->updateAvatar();
        return array("SUCCESS"=>"Accepted");
    }

    //This function cancels a players request to join a party
    private static function rejectPlayerParty($partyID,$playerVotedOn){
        $party = new partyController($partyID);
        $avatar = new avatarController($playerVotedOn);
        $party->removePendingRequests($avatar->getAvatarID());
        $members = $party->getMembers();
        chatlogGroupController::joinFail($avatar->getAvatarID(),$party->getPartyID());
        self::removePartyVotes($members,$avatar->getAvatarID());
        $party->uploadParty();
        return array("SUCCESS"=>"Rejected");
    }

    //This resets the groups votes surrounding a player
    private static function removePartyVotes($membersArray,$playerVotedOn)
    {
        $avatarCurrent = new avatarController($playerVotedOn);
        foreach ($membersArray as $player) {
            $avatar = new avatarController($player);
            $avatar->changePartyVote($avatarCurrent->getAvatarID(), 0);
            $avatar->updateAvatar();
        }
    }

    //This resets the votes of all players surrounding a player
    private static function removeMapVotes($avatarArray,$playerVotedOn){
        $avatarCurrent = new avatarController($playerVotedOn);
        foreach ($avatarArray as $avatar){
            $newAvatar = new avatarController($avatar);
            $newAvatar->changePartyVote($avatarCurrent->getAvatarID(), 0);
            $newAvatar->updateAvatar();
        }
    }

    //This function changes the name of a players group
    public static function changeGroupName($avatarID,$newName){
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
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
                    return array("SUCCESS"=>true);
                }
            }
        }
    }

    public static function cancelJoin($avatarID,$playerID){
        $otherPlayer = new avatarController($playerID);
        $avatar = new avatarController($avatarID);
        if ($otherPlayer->getAvatarID() != $playerID){
            return array("ERROR" => 20);
        } else {
            $newParty = new partyController($otherPlayer->getPartyID());
            if (in_array($avatar->getAvatarID(), $newParty->getMembers()) === true) {
                return array("ERROR" => 21);
            } else {
                $newParty->removePendingRequests($avatar->getAvatarID());
                $newParty->uploadParty();
                chatlogGroupController::cancelGroupRequest($avatar->getAvatarID(),$newParty->getPartyID());
                return array("SUCCESS"=>true);
            }
        }
    }

    public static function getResearchTeaching($avatarID,$playerID){
        $otherPlayer = new avatarController($playerID);
        if ($otherPlayer->getAvatarID() != $playerID){
            return array("ERROR" => 20);
        } else {
            $player = new avatarController($avatarID);
            if ($player->getStamina() < 2){
                return array("ERROR"=>0);
            } else {
                $unknownResearch = [];
                foreach ($player->getResearched() as $research) {
                    if (!in_array($research, $otherPlayer->getResearched())) {
                        array_push($unknownResearch, $research);
                    }
                }
                if (count($unknownResearch)>0){
                    $buildingsArray = [];
                    foreach ($unknownResearch as $research){
                        $canResearch = true;
                        $building = new buildingController("");
                        $building->createNewBuilding($research,$player->getZoneID());
                        $buildingRequired = $building->getBuildingsRequired();
                        if ($buildingRequired !== 0 && $buildingRequired !== "0") {
                            if (!in_array($buildingRequired,$otherPlayer->getResearched())){
                                $canResearch = false;
                            }
                        }
                        if ($canResearch == true) {
                            $buildingsArray[$research] = array("templateID" => $building->getBuildingTemplateID(), "buildingName" => $building->getName(), "icon" => $building->getIcon());
                        }
                    }
                    return array("research"=>$buildingsArray,"player"=>$otherPlayer->getAvatarID());
                } else {
                    return array("ERROR"=>47);
                }
            }
        }

    }

    public static function teachPlayerResearch($playerID,$avatarID,$research)
    {
        $avatar = new avatarController($avatarID);
        if ($avatar->getStamina() < 2) {
            return array("ERROR" => 0);
        } else {
            if (!in_array($research, $avatar->getResearched())) {
                return array("ERROR" => 39);
            } else {
                $otherPlayer = new avatarController($playerID);
                if ($otherPlayer->getAvatarID() != $playerID) {
                    return array("ERROR" => 48);
                } else {
                    if (in_array($research, $otherPlayer->getResearched())) {
                        return array("ERROR" => 49);
                    } else {
                        $building = new buildingController("");
                        $building->createNewBuilding($research, $otherPlayer->getZoneID());
                        if ($building->getBuildingTemplateID() != $research) {
                            return array("ERROR" => 50);
                        } else {
                            $buildingRequired = $building->getBuildingsRequired();
                            if ($buildingRequired !== 0 && $buildingRequired !== "0") {
                                if (!in_array($buildingRequired, $otherPlayer->getResearched())) {
                                    return array("ERROR" => 51);
                                }
                            }
                            $avatar->useStamina(2);
                            $avatar->addPlayStatistics("research",2);
                            $otherPlayer->addResearched($research);
                            $avatar->updateAvatar();
                            $otherPlayer->updateAvatar();
                            chatlogPersonalController::teachPlayerResearch($avatar->getAvatarID(),$building->getName(),$otherPlayer->getProfileID());
                            return array("SUCCESS"=>true);
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
        $currentAvatars = avatarController::getAllMapAvatars($avatar->getMapID());
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