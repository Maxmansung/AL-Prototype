<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class specialZoneView
{

    protected $specialZoneDetails;
    protected $specialZoneFavours;
    protected $isSpecialZone;

    function __construct($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $shrineZone = shrineController::findShrine($zone->getZoneID());
        $party = new partyController($avatar->getPartyID());
        if ($shrineZone !== false) {
            $this->isSpecialZone = $shrineZone;
            $shrine = new shrineController($shrineZone);
            $this->specialZoneDetails = $shrine->returnViewVars($avatar->getAvatarID());
            $this->calculateSpecialZoneFavours($shrine->getMinParty(), $shrine->getMaxParty(), count($party->getMembers()));
        } else {
            $this->isSpecialZone = $shrineZone;
        }
    }

    function returnVars(){
        return get_object_vars($this);
    }



    function calculateSpecialZoneFavours($min,$max,$current){
        if ($current <= $max && $current>= $min){
            $this->specialZoneFavours = true;
        } else {
            $this->specialZoneFavours = false;
        }
    }
}