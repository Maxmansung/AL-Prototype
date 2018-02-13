<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class mapView
{

    protected $zoneName;
    protected $zoneNumber;
    protected $coordinateX;
    protected $coordinateY;
    protected $findingChances;
    protected $biomeType;
    protected $playerKnown;
    protected $avatars;
    protected $biomeValue;
    protected $description;
    protected $descriptionLong;
    protected $zoneProtected;
    protected $canEnterZone;
    protected $zoneOwners;
    protected $partyInZone;
    protected $outpostBuilt;
    protected $firepitAlert;
    protected $mapID;
    protected $isSpecialZone;
    protected $specialZoneDetails;
    protected $specialZoneFavours;
    protected $biomeImage;
    protected $lockValue;

    private function __construct($zone, $avatar, $party)
    {
        $this->mapID = $zone->getMapID();
        $this->setZoneName($zone->getZoneID());
        $smokeSignals = buildingController::getConstructedBuildingID("Smoke",$zone->getZoneID());
        if (is_object($smokeSignals)){
            $this->setFirepitAlert(true);
        } else {
            $this->setFirepitAlert(false);
        }
        $this->setZoneNumber(ltrim($zone->getName(), "z"));
        $this->setCoordinateX($zone->getCoordinateX());
        $this->setCoordinateY($zone->getCoordinateY());
        $exploration = $party->getZoneExploration();
        $this->setPlayerKnown($exploration[$this->zoneNumber][0]);
        $this->setCanEnterZone(false);
        if ($this->getPlayerKnown() === false) {
            $this->setFindingChances(1);
            $this->setBiomeType(-1);
            $this->setAvatars(array());
            $this->setBiomeValue("");
            $this->setDescription("");
            $this->setDescriptionLong("");
            $this->setProtected("empty");
            $this->setLockValue(0);
            $this->setOutpostName("None");
            $this->setZoneOwners(null);
            $this->setIsSpecialZone(false);
        }
        else {
            $biome = new biomeTypeController($exploration[$this->zoneNumber][0]);
            $this->biomeImage = $biome->getBiomeImage();
            $this->setBiomeValue($biome->getValue());
            $this->setDescription($biome->getDescription());
            $this->setDescriptionLong($biome->getDescriptionLong());
            $this->setFindingChances($exploration[$this->zoneNumber][1]);
            $this->setBiomeType($exploration[$this->zoneNumber][0]);
            $shrineZone = shrineController::findShrine($zone->getZoneID());
            $this->setAvatars(array());
            $this->setPartyInZone(false);
            foreach ($party->getMembers() as $member) {
                if (in_array($member, $zone->getAvatars())) {
                    $this->setPartyInZone(true);
                }
            }
            if ($this->partyInZone === true){
                $this->setAvatars( mapView::getAvatarNames($zone->getAvatars(),$avatar->getAvatarID()));
            }
            if ($shrineZone !== false){
                $this->setIsSpecialZone($shrineZone);
                $shrine = new shrineController($shrineZone);
                $this->setSpecialZoneDetails($shrine->returnViewVars($avatar->getAvatarID()));
                $this->calculateSpecialZoneFavours($shrine->getMinParty(),$shrine->getMaxParty(),count($party->getMembers()));
            } else {
                $this->setIsSpecialZone($shrineZone);
                if ($zone->getControllingParty() === $avatar->getPartyID()) {
                    $building = buildingController::getConstructedBuildingID("Outpost", $zone->getZoneID());
                    if ($building->getBuildingID() != null) {
                        $this->setOutpostBuilt(true);
                        $this->setFirepitAlert(false);
                    }
                } else {
                    $this->setOutpostBuilt(false);
                }
                if ($this->partyInZone === true) {
                    $this->setProtected($zone->getControllingParty());
                    $this->setLockValue(buildingController::getLockValue($zone->getZoneID()));
                    if ($this->isProtected() !== null) {
                        $this->outpostName = $zone->getZoneOutpostName();
                        $party = new partyController($zone->getControllingParty());
                        $this->setZoneOwners($party->getPartyName());
                        if ($this->lockValue < 1 || $this->isProtected() == $avatar->getPartyID()) {
                            $this->setCanEnterZone(true);
                        } else{
                            $this->setCanEnterZone(false);
                        }
                    } else {
                        $this->setCanEnterZone(true);
                    }
                }
            }
        }
    }

    public function __toString()
    {
        $output = $this->zoneName;
        $output .= '/ '.$this->zoneNumber;
        $output .= '/ '.$this->coordinateX;
        $output .= '/ '.$this->coordinateY;
        $output .= '/ '.$this->findingChances;
        $output .= '/ '.$this->playerKnown;
        $output .= '/ '.$this->avatars;
        $output .= '/ '.$this->description;
        $output .= '/ '.$this->descriptionLong;
        $output .= '/ '.$this->zoneProtected;
        $output .= '/ '.$this->lockValue;
        $output .= '/ '.$this->canEnterZone;
        $output .= '/ '.$this->zoneOwners;
        $output .= '/ '.$this->partyInZone;
        $output .= '/ '.$this->outpostBuilt;
        $output .= '/ '.$this->outpostName;
        $output .= '/ '.$this->firepitAlert;
        $output .= '/ '.$this->isSpecialZone;
        $output .= '/ '.$this->specialZoneDetails;
        return $output;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function getZoneName(){
        return $this->zoneName;
    }

    function setZoneName($var){
        $this->zoneName = $var;
    }

    function getZoneNumber(){
        return $this->zoneNumber;
    }

    function setZoneNumber($var){
        $this->zoneNumber = intval($var);
    }

    function getCoordinateX(){
        return $this->coordinateX;
    }

    function setCoordinateX($var){
        $this->coordinateX = intval($var);
    }

    function getCoordinateY(){
        return $this->coordinateY;
    }

    function setCoordinateY($var){
        $this->coordinateY = intval($var);
    }

    function getFindingChances(){
        return $this->findingChances;
    }

    function setFindingChances($var){
        $this->findingChances = intval($var);
    }

    function getBiomeType(){
        return $this->biomeType;
    }

    function setBiomeType($var){
        $this->biomeType = intval($var);
    }

    function getPlayerKnown(){
        return $this->playerKnown;
    }

    function setPlayerKnown($var){
        if ($var == "x") {
            $this->playerKnown = false;
        } else {
            $this->playerKnown = boolval($var);
        }
    }

    function getAvatars(){
        return $this->avatars;
    }

    function setAvatars($var){
        $this->avatars = $var;
    }

    function getBiomeValue(){
        return $this->biomeValue;
    }

    function setBiomeValue($var){
        $this->biomeValue = $var;
    }

    function getDescription(){
        return $this->description;
    }

    function setDescription($var){
        $this->description = $var;
    }

    function getDescriptionLong(){
        return $this->descriptionLong;
    }

    function setDescriptionLong($var){
        $this->descriptionLong = $var;
    }

    function isProtected(){
        return $this->zoneProtected;
    }

    function setProtected($var){
        $this->zoneProtected = $var;
    }

    function getLockValue(){
        return $this->lockValue;
    }

    function setLockValue($var){
        $this->lockValue = intval($var);
    }

    function getCanEnterZone(){
        return $this->canEnterZone;
    }

    function setCanEnterZone($var){
        $this->canEnterZone = intval($var);
    }

    function getFirepitAlert(){
        return $this->firepitAlert;
    }

    function setFirepitAlert($var){
        $this->firepitAlert = boolval($var);
    }

    function getOutpostBuilt(){
        return $this->outpostBuilt;
    }

    function setOutpostBuilt($var){
        $this->outpostBuilt = boolval($var);
    }

    function getZoneOwners(){
        return $this->zoneOwners;
    }

    function setZoneOwners($var){
        $this->zoneOwners = $var;
    }

    function getPartyInZone(){
        return $this->partyInZone;
    }

    function setPartyInZone($var){
        $this->partyInZone = boolval($var);
    }

    function getOutpostName(){
        return $this->outpostName;
    }

    function setOutpostName($var){
        $this->outpostName = $var;
    }

    function getIsSpecialZone(){
        return $this->isSpecialZone;
    }

    function setIsSpecialZone($var){
        $this->isSpecialZone = $var;
    }

    function getSpecialZoneDetails(){
        return $this->specialZoneDetails;
    }

    function setSpecialZoneDetails($var){
        $this->specialZoneDetails = $var;
    }

    function getSpecialZoneFavours(){
        return $this->specialZoneFavours;
    }

    function calculateSpecialZoneFavours($min,$max,$current){
        if ($current <= $max && $current>= $min){
            $this->specialZoneFavours = true;
        } else {
            $this->specialZoneFavours = false;
        }
    }


    //This returns the mapView item for the avatars zone
    public static function getPlayerMapZoneController($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $party = new partyController($avatar->getPartyID());
        return new mapView($zone,$avatar,$party);
    }

    //This returns the map array view including the avatar and current zones
    public function arrayView($profileAvatar)
    {
        $avatar = new avatarController($profileAvatar);
        $party = new partyController($avatar->getPartyID());
        $zonesArray = zoneController::getAllZones($avatar->getMapID());
        $mapZones = [];
        $counter = 0;
        foreach ($zonesArray as $zone){
            $tempZone = new mapView($zone,$avatar,$party,0);
            $mapZones[$counter] = $tempZone->returnVars();
            $counter++;
        }
        $itemsView = $this->allItemsView($profileAvatar);
        $map = new mapController($avatar->getMapID());
        $logs = self::getZoneLogs($avatar->getZoneID(),$party->getPlayersKnown(),$map->getCurrentDay(),$avatar->getAvatarID());
        $data = array("zone"=>$this->returnVars(),"mapZones"=>$mapZones,"itemsView"=>$itemsView,"logs"=>$logs);
        return $data;
    }

    //This returns the the avatar and current zone
    public function singleZoneView($profileAvatar)
    {
        $avatar = new avatarController($profileAvatar);
        $party = new partyController($avatar->getPartyID());
        $itemsView = $this->allItemsView($profileAvatar);
        $map = new mapController($avatar->getMapID());
        $logs = self::getZoneLogs($avatar->getZoneID(),$party->getPlayersKnown(),$map->getCurrentDay(),$avatar->getAvatarID());
        $data = array("zone"=>$this->returnVars(),"itemsView"=>$itemsView,"logs"=>$logs);
        return $data;
    }

    //This returns all of the logs for a player on the map screen
    private function getZoneLogs($zoneID,$playersKnown,$day,$avatarID){
        $logsStart = chatlogMovementController::getAllMovementLogs($zoneID,$playersKnown,$day,$avatarID);
        $logsMore = chatlogPersonalController::getAllSearchLogs($zoneID,$day,$avatarID);
        foreach ($logsMore as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $logsStart)) {
                $log["messageTimestamp"] += 1;
            }
            $logsStart[$log["messageTimestamp"]] = $log;
        }
        return $logsStart;
    }

    //This returns the mapView item for any zone
    public static function getZoneInfo($zoneID, $avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($zoneID);
        $party = new partyController($avatar->getPartyID());
        return new mapView($zone, $avatar,$party,0);
    }


    //This returns the mapView item for the avatars zone
    public static function getCurrentZoneInfo($avatarID)
    {
        playerMapZoneController::updateOverallZoneExploration($avatarID);
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $zone = new zoneController($avatar->getZoneID());
        return new mapView($zone, $avatar,$party);
    }

    //This returns a view of just the backpack and the ground
    public function allItemsView($avatarID){
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $map = new mapController($avatar->getMapID());
        $logs = self::getZoneLogs($avatar->getZoneID(),$party->getPlayersKnown(),$map->getCurrentDay(),$avatar->getAvatarID());
        $items = array("backpack" =>$this->getBackpackItems($avatar->getAvatarID()), "ground" => $this->getZoneItemsArray(), "avatarLoc"=>$avatar->getZoneID(),"backpackSize"=>$avatar->getMaxInventorySlots(),"logs"=>$logs);
        return $items;
    }

    //This returns the ground items array for the zone
    private function getZoneItemsArray(){
        return itemController::getItemArray($this->mapID,"ground",$this->zoneName);
    }

    //This returns the backpack items array for the avatar
    private function getBackpackItems($avatarID){
        return itemController::getItemArray($this->mapID,"backpack",$avatarID);
    }

    //This returns the avatar names as an array of profile IDs
    private static function getAvatarNames($avatarList,$avatarID){
        $newArray = [];
        foreach ($avatarList as $avatar){
            if ($avatar != $avatarID) {
                $tempAvatar = new avatarController($avatar);
                array_push($newArray,$tempAvatar->getProfileID());
            }
        }
        return $newArray;
    }
}