<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class otherAvatarView
{
    protected $avatarID;
    protected $profileID;
    protected $partyName;
    protected $readiness;
    protected $inParty;
    protected $avatarImage;
    protected $researchTeach;
    protected $messages;
    protected $inzone;
    protected $requestSent;
    protected $kickingVote;
    protected $yourVote;
    protected $partyVotes;
    protected $self;
    protected $waitingToJoin;


    function __construct($other,$self,$all,$membersArray,$party)
    {
        $this->avatarID = $other->getAvatarID();
        $this->profileID = $other->getProfileID();
        $this->readiness = $other->getReady();
        $this->waitingToJoin = false;
        if ($self->getPartyID() === $other->getPartyID()){
            $this->inParty = true;
            $this->partyName = $party->getPartyName();
        } else {
            $this->inParty = false;
            $otherParty = new partyController($other->getPartyId());
            $this->partyName = $otherParty->getPartyName();
            if (in_array($self->getAvatarID(),$otherParty->getPendingRequests())){
                $this->waitingToJoin = true;
            }
        }
        if ($self->getAvatarID() === $other->getAvatarID()){
            $this->self = true;
        } else {
            $this->self = false;
        }
        $this->avatarImage = $other->getAvatarImage();
        if ($all === true){
            if ($other->getZoneID() == $self->getZoneID()) {
                $this->inzone = true;
                $this->researchTeach = partyZonePlayerController::getUnknownResearch($other,$self,true);
                if (in_array($self->getAvatarID(),$party->getPendingRequests())){
                    $this->requestSent = true;
                } else {
                    $this->requestSent = false;
                }
            } else {
                $this->inzone = false;
            }
            $this->messages = [];
            $partySelf = new partyController($self->getPartyID());
            if (in_array($other->getAvatarID(),$partySelf->getPendingBans())){
                $this->kickingVote = true;
            } else {
                $this->kickingVote = false;
            }
            $finalArray = [];
            foreach ($membersArray as $player){
                $votes = $player->getPartyVote();
                $finalArray[$player->getAvatarID()] = $votes[$other->getAvatarID()];
                if ($player->getAvatarID() === $self->getAvatarID()){
                    $this->yourVote = $votes[$other->getAvatarID()];
                }
            }
            $this->partyVotes = $finalArray;
        }
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function createNewView($avatarID,$newID)
    {
        $newIDClean = preg_replace(data::$cleanPatterns['num'],"",$newID);
        $self = new avatarController($avatarID);
        $other = new avatarController($newIDClean);
        $party = new partyController($self->getPartyID());
        $view = new otherAvatarView($other,$self,true,[],$party);
        return $view->returnVars();
    }



    public static function getAllPlayers($self,$party,$type,$arrayObjects)
    {
        $totalArray = [];
        foreach ($arrayObjects as $avatar){
            if ($type === "inParty") {
                $temp = new otherAvatarView($avatar,$self,true,$arrayObjects,$party);
                $totalArray[$avatar->getAvatarID()] = $temp->returnVars();
            } else {
                $temp = new otherAvatarView($avatar,$self,true,$arrayObjects,$party);
                $totalArray[$avatar->getAvatarID()] = $temp->returnVars();
            }
        }
        return $totalArray;
    }


}