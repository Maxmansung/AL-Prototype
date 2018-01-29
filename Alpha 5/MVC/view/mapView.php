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
    protected $zoneBuildings;
    protected $storageBuilt;
    protected $buildingTempBonus;
    protected $firepitBonus;
    protected $lockValue;
    protected $lockTotal;
    protected $canEnterZone;
    protected $zoneOwners;
    protected $partyInZone;
    protected $outpostBuilt;
    protected $biomeTempMod;
    protected $outpostName;
    protected $firepitAlert;
    protected $mapID;
    protected $isSpecialZone;
    protected $specialZoneDetails;
    protected $specialZoneFavours;

    private function __construct($zone, $avatar, $party, $biomeMod)
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
        $this->setBiomeTempMod($biomeMod);
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
            $this->setZoneBuildings(array());
            $this->setStorageBuilt(0);
            $this->setBuildingTempBonus(0);
            $this->setFirepitBonus(0);
            $this->setLockValue(0);
            $this->setLockTotal(0);
            $this->setOutpostName("None");
            $this->setZoneOwners(null);
            $this->setIsSpecialZone(false);
        }
        else {
            $biome = new biomeTypeController($exploration[$this->zoneNumber][0]);
            $this->setBiomeValue($biome->getValue());
            $this->setDescription($biome->getDescription());
            $this->setDescriptionLong($biome->getDescriptionLong());
            $this->setFindingChances($exploration[$this->zoneNumber][1]);
            $this->setBiomeType($exploration[$this->zoneNumber][0]);
            $shrineZone = shrineController::findShrine($zone->getZoneID());
            $this->setAvatars(array());
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
                $this->setPartyInZone(false);
                foreach ($party->getMembers() as $member) {
                    if (in_array($member, $zone->getAvatars())) {
                        $this->setPartyInZone(true);
                    }
                }
                if ($this->partyInZone === true) {
                    $this->setProtected($zone->getControllingParty());
                    $this->setStorageBuilt($zone->getStorage());
                    $this->setLockValue(buildingController::getLockValue($zone->getZoneID()));
                    if ($this->lockValue > 0) {
                        $lock = buildingController::getConstructedBuildingID("GateLock", $this->zoneName);
                        $this->setLockTotal(buildingController::lockTotal($lock));
                    } else {
                        $this->setLockTotal(0);
                    }
                    if ($this->partyInZone === true) {
                        $this->setAvatars(self::getAvatarNames($zone->getAvatars(), $zone->getMapID(), $avatar->getAvatarID()));
                    }
                    if ($this->isProtected() !== "empty") {
                        $this->outpostName = $zone->getZoneOutpostName();
                        $party = new partyController($zone->getControllingParty());
                        $this->setZoneOwners($party->getPartyName());
                        if ($this->lockValue < 1 || $this->isProtected() == $avatar->getPartyID()) {
                            $this->setCanEnterZone(true);
                            $this->setZoneBuildings($zone->getBuildings());
                            $this->setFirepitBonus(buildingController::getFirepitBonus($zone->getZoneID()));
                            $this->setBuildingTempBonus(buildingController::getZoneTempBonus($zone->getBuildings(), $zone->getZoneID()));
                        } else {
                            $this->setFirepitBonus(0);
                            $this->setBuildingTempBonus(0);
                        }
                    } else {
                        $this->setZoneBuildings($zone->getBuildings());
                        $this->setCanEnterZone(true);
                        $this->setFirepitBonus(buildingController::getFirepitBonus($zone->getZoneID()));
                        $this->setBuildingTempBonus(buildingController::getZoneTempBonus($zone->getBuildings(), $zone->getZoneID()));
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
        $output .= '/ '.$this->zoneBuildings;
        $output .= '/ '.$this->storageBuilt;
        $output .= '/ '.$this->buildingTempBonus;
        $output .= '/ '.$this->firepitBonus;
        $output .= '/ '.$this->lockValue;
        $output .= '/ '.$this->lockTotal;
        $output .= '/ '.$this->canEnterZone;
        $output .= '/ '.$this->zoneOwners;
        $output .= '/ '.$this->partyInZone;
        $output .= '/ '.$this->outpostBuilt;
        $output .= '/ '.$this->biomeTempMod;
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

    function getBuildings(){
        return $this->zoneBuildings;
    }

    function setBuildings($var){
        $this->zoneBuildings = $var;
    }

    function getStorage()
    {
        return $this->storageBuilt;
    }

    function setStorage($var){
        $this->storageBuilt = intval($var);
    }

    function getBuildingTempBonus()
    {
        return $this->buildingTempBonus;
    }

    function setBuildingTempBonus($var){
        $this->buildingTempBonus = intval($var);
    }

    function getLockValue(){
        return $this->lockValue;
    }

    function setLockValue($var){
        $this->lockValue = intval($var);
    }

    function getLockTotal(){
        return $this->lockTotal;
    }

    function setLockTotal($var){
        $this->lockTotal = intval($var);
    }

    function getCanEnterZone(){
        return $this->canEnterZone;
    }

    function setCanEnterZone($var){
        $this->canEnterZone = intval($var);
    }

    function getBiomeTempMod(){
        return $this->biomeTempMod;
    }

    function setBiomeTempMod($var){
        $this->biomeTempMod = intval($var);
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

    function getZoneBuildings(){
        return $this->zoneBuildings;
    }

    function setZoneBuildings($var){
        $this->zoneBuildings = $var;
    }

    function getStorageBuilt(){
        return $this->storageBuilt;
    }

    function setStorageBuilt($var){
        $this->storageBuilt = boolval($var);
    }

    function getFirepitBonus(){
        return $this->firepitBonus;
    }

    function setFirepitBonus($var){
        $this->firepitBonus = intval($var);
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
        $biome = new biomeTypeController($zone->getBiomeType());
        return new mapView($zone,$avatar,$party,$biome->getTemperatureMod());
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
        $biome = new biomeTypeController($zone->getBiomeType());
        return new mapView($zone, $avatar,$party,$biome->getTemperatureMod());
    }

    //This returns a view of just the backpack and the ground
    public function allItemsView($avatarID){
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $map = new mapController($avatar->getMapID());
        $logs = self::getZoneLogs($avatar->getZoneID(),$party->getPlayersKnown(),$map->getCurrentDay(),$avatar->getAvatarID());
        $items = array("backpack" =>$this->getBackpackItems($avatar->getAvatarID()), "ground" => $this->getZoneItemsArray(), "avatarLoc"=>$avatar->getZoneID(),"recipes"=>$this->createRecipeList($avatar,$this->zoneBuildings),"backpackSize"=>$avatar->getMaxInventorySlots(),"logs"=>$logs);
        return $items;
    }


    //This returns a list of recipes that can be made based on the items in the players backpack and the buildings around
    private function createRecipeList($avatar,$zoneBuildings){
        $itemList = itemController::returnItemIDArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
        return recipeController::findRecipe($itemList,$zoneBuildings);
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
    private static function getAvatarNames($avatarList, $mapID,$avatarID){
        $newArray = [];
        foreach ($avatarList as $avatar){
            if ($avatar != $avatarID) {
                $newName = str_replace($mapID, "", $avatar);
                array_push($newArray, $newName);
            }
        }
        return $newArray;
    }
}