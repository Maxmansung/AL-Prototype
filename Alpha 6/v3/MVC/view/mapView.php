<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class mapView
{

    protected $xaxis;
    protected $yaxis;
    protected $zoneID;
    protected $biome;
    protected $depleted;
    protected $currentZone;
    protected $partyMember;
    protected $camp;

    function __construct($zone,$knownZones,$avatar)
    {
        $this->xaxis = $zone->getCoordinateX();
        $this->yaxis = $zone->getCoordinateY();
        $this->zoneID = $zone->getZoneID();
        $this->biome = $knownZones[$zone->getName()][0];
        $this->depleted = $knownZones[$zone->getName()][1];
        if ($zone->getZoneID() === $avatar->getZoneID()){
            $this->currentZone = true;
        }
        if ($zone->getControllingParty() === $avatar->getPartyID()){
            $this->camp = true;
        }
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function getView($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $zoneList = zoneController::getAllZones($avatar->getMapID(),true);
        $finalArray = [];
        foreach ($zoneList as $zone){
            $temp = new mapView($zone,$party->getZoneExploration(),$avatar);
            $finalArray[$temp->zoneID] = $temp->returnVars();
        }
        return $finalArray;
    }
}