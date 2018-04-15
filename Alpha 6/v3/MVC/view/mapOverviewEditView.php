<?php
class mapOverviewEditView
{

    protected $mapVars;
    protected $avatarsAlive;
    protected $avatarsDead;
    protected $zones;

    public static function getSingleMapDetail($profile,$mapID){
        $profile->getProfileAccess();
        $mapIDClean = intval(preg_replace('#[^0-9]#i', '', $mapID));
        if ($profile->getAccessEditMap()===0){
            return array("ERROR"=>28);
        } else {
            $map = new mapController($mapIDClean);
            $view = new mapOverviewEditView($map);
            return $view->returnVars();
        }
    }

    public static function getAllMapsOverview($profile){
        $profile->getProfileAccess();
        if ($profile->getAccessEditMap()===0){
            return array("ERROR"=>28);
        } else {
            $mapList = mapController::joingames(true);
            return $mapList;
        }
    }

    private function __construct($mapController)
    {
        $this->mapVars = $mapController->returnVars();
        $this->getAvatarsAlive($mapController->getMapID());
        $this->zones = zoneController::getAllZones($mapController->getMapID(),true);

    }

    private function getAvatarsAlive($mapID){
        $list = avatarController::getAllMapAvatars($mapID,false);
        $newArray = [];
        $deadArray = [];
        foreach ($list as $avatar){
            if ($avatar->getReady() != "dead"){
                $newArray[$avatar->getAvatarID()] = $avatar->returnVars();
            } else {
                array_push($deadArray,$avatar->getProfileID());
            }
        }
        $this->avatarsAlive = $newArray;
        $this->avatarsDead = $deadArray;
    }

    public function returnVars(){
        return get_object_vars($this);
    }

}