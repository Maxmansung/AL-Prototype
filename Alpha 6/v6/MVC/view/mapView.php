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
    protected $marker;

    function __construct($zone,$knownZones,$avatar)
    {
        $this->xaxis = $zone->getCoordinateX();
        $this->yaxis = $zone->getCoordinateY();
        $this->zoneID = $zone->getZoneID();
        $name = "biome".$zone->getBiomeType();
        $biome = new $name();
        if ($biome->getVisibleMap() === true){
            $this->biome = $zone->getBiomeType();
            if ($knownZones[$zone->getName()][1] === "x"){
                $this->depleted = 1;
            } else {
                $this->depleted = $knownZones[$zone->getName()][1];
            }
        } else {
            $this->biome = $knownZones[$zone->getName()][0];
            $this->depleted = $knownZones[$zone->getName()][1];
        }
        $this->marker = $knownZones[$zone->getName()][2];
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

    public static function getView($avatar,$party)
    {
        $zoneList = zoneController::getAllZones($avatar->getMapID(),true);
        $finalArray = [];
        foreach ($zoneList as $zone){
            $temp = new mapView($zone,$party->getZoneExploration(),$avatar);
            $finalArray[$temp->zoneID] = $temp->returnVars();
        }
        return $finalArray;
    }

    public static function getViewWithZone($avatarID,$zoneID)
    {
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $finalArray["mapInformation"] = mapView::getView($avatar,$party);
        $zoneIDClean = preg_replace(data::$cleanPatterns['num'],"",$zoneID);
        $zone = new zoneController($zoneIDClean);
        $zoneDetails = new zoneDetailView($zone,$party,$avatar);
        $finalArray["details"] = $zoneDetails->returnVars();
        return $finalArray;
    }
}