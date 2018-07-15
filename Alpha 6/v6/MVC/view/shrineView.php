<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class shrineView
{
    protected $message;
    protected $icon;
    protected $name;
    protected $cost;
    protected $canWorship;
    protected $godClass;
    protected $tributeCurrent;
    protected $costMessage;
    protected $shrineID;
    protected $class;
    protected $personalAchieve;

    function __construct($avatar,$shrine,$party,$map,$single)
    {
        $this->shrineID = $shrine->getShrineID();
        $this->godClass = $shrine->getTypeName();
        $this->name = $shrine->getShrineName();
        if ($single === true){
            $this->message = $shrine->getDescription();
            $this->cost = $shrine->getWorshipCost();
            $this->costMessage = $shrine->getWorshipDescription();
            $this->icon = $shrine->getShrineIcon();
            $this->sacrificeImage = "";
        }
        $this->canWorship = false;
        if (count($party->getMembers()) <= $shrine->getMaxParty()){
            if (count($party->getMembers()) >= $shrine->getMinParty()){
                $this->canWorship = true;
            }
        }
        $this->tributeCurrent = $shrine->shrineRanks($map,$party->getPlayersKnown());
        $this->class = $shrine->getOverallType();
        $this->personalAchieve = $shrine->checkShrineFavour($this->tributeCurrent,$avatar->getAvatarID(),$avatar->getPartyID());
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function createTestView($avatarID){
        $avatar = new avatarController($avatarID);
        $zone= new zoneController($avatar->getZoneID());
        $name = "shrine".$zone->getProtectedType();
        $shrine = new $name();
        $party = new partyController($avatar->getPartyID());
        $map = new mapController($avatar->getMapID());
        $view = new shrineView($avatar,$shrine,$party,$map,true);
        return $view->returnVars();
    }

    public static function createAllShrineView($avatar,$party,$map){
        $list = zoneController::getMapShrines($map->getMapID());
        $finalArray = [];
        foreach ($list as $shrine){
            $temp = new shrineView($avatar,$shrine,$party,$map,false);
            $finalArray[$shrine->getShrineID()] = $temp->returnVars();
        }
        return $finalArray;
    }
}