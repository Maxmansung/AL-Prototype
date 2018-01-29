<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class shrinePlayerView
{

    protected $player;
    protected $party;
    protected $count;
    protected $avatarID;

    public function __construct($avatarID,$count,$playersKnown)
    {
        if (in_array($avatarID,$playersKnown) === true) {
            $avatar = new avatarController($avatarID);
            $partyTemp = new partyController($avatar->getPartyID());
            $this->player = $avatar->getProfileID();
            $this->party = $partyTemp->getPartyName();
            $this->avatarID = $avatarID;
            $this->count = $count;
        } else {
            $this->player = "Unknown";
            $this->party = "Unknown";
            $this->count = $count;
        }
    }

    public function returnVars(){
        return get_object_vars($this);
    }



}