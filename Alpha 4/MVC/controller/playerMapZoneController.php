<?php

///////// THIS CONTROLLER IS USED TO CREATE THE MAP AND WORK OUT WHICH RECIPES CAN BE CREATED



include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/zoneController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/biomeTypeController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/itemController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/recipeController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/buildingController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogAllController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/shrineController.php");
class playerMapZoneController
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
                        $this->setAvatars(playerMapZoneController::getAvatarNames($zone->getAvatars(), $zone->getMapID(), $avatar->getAvatarID()));
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

    //////INPUT FUNCTIONS////

    //This function is used to move the avatar in a direction around the map
    public static function moveAvatar($avatarID,$dir){
        $avatar = new avatarController($avatarID);
        if ($avatar->getStamina() <= 0){
            return array("ERROR" => 0);
        } else {
            $avatar->useStamina(1);
            $currentZone = new zoneController($avatar->getZoneID());
            $newZone = new zoneController($avatar->getZoneID());
            $newZone = $newZone->nextMap($dir);
            //This small section prevents players from entering zones not claimed by their party
            if ($newZone->getControllingParty() !== "empty") {
                if ($newZone->getControllingParty() !== $avatar->getPartyID()) {
                    //return array("ERROR" => 1);
                }
            } elseif ($newZone->getZoneID() == "") {
                return array("ERROR" => 2);
            }
            chatlogMovementController::leaveCurrentZone($avatarID,$dir);
            $metAvatars = $newZone->getAvatars();
            $currentZone->removeAvatar($avatar->getAvatarID());
            $currentZone->updateZone();
            $newZone->addAvatar($avatar->getAvatarID());
            $newZone->adjustCounter(1);
            $newZone->updateZone();
            $avatar->setZoneID($newZone->getZoneID());
            $avatar->addPlayStatistics("move",1);
            $avatar->updateAvatar();
            $party = new partyController($avatar->getPartyID());
            foreach ($metAvatars as $player) {
                $party->addPlayersKnown($player);
            }
            $party->uploadParty();
            partyController::removeAllInvites($avatarID);
            chatlogMovementController::enterNewZone($avatarID,$dir);
            return array("Success");
        }
    }

    //This function is used for searching a zone
    public static function searchZone($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        if ($avatar->getStamina() <= 0) {
            return array("ERROR" => 0);
        } else {
            if ($zone->getProtectedType()!== "none"){
                return array("ERROR" => 59);
            } else {
                if ($zone->getFindingChances() <= 0) {
                    return array("ERROR" => 4);
                } else {
                    $zone->reduceFindingChances();
                    $avatar->useStamina(1);
                    $avatar->addPlayStatistics("search", 1);
                    $findingchance = self::findingChances($zone->getBiomeType(), $avatar->getFindingChanceFail());
                    if ($findingchance == 0) {
                        $avatar->increaseFindingChanceFail(1);
                        $avatar->updateAvatar();
                        $zone->updateZone();
                        return array("ERROR" => 5);
                    } else {
                        $itemID = self::addNewItem($zone->getBiomeType(), $zone->getMapID(), $zone->getZoneID());
                        if ($itemID != "ERROR") {
                            $avatar->resetFindingChanceFail();
                            $zone->updateZone();
                            $avatar->updateAvatar();
                            return array("Success" => true);
                        } else {
                            return array("ERROR" => "X");
                        }
                    }
                }
            }
        }
    }

    //This function works out the finding chances
    private static function findingChances($biomeID,$playerFindingChance){
        $biome = new biomeTypeController($biomeID);
        return rand(0, ($biome->getFindingChanceMod()-$playerFindingChance));
    }

    //This function is used to both drop and pick up items
    public static function dropItem($tempitem, $avatarID){
        $itemID = intval($tempitem);
        $item = new itemController($itemID);
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        if ($zone->getProtectedType() !== "none") {
            return array("ERROR"=>59);
        } else {
            if ($item->getLocationID() === $zone->getZoneID()) {
                if (count($avatar->getInventory()) < $avatar->getMaxInventorySlots()) {
                    $item->setItemLocation("backpack");
                    $item->setLocationID($avatar->getAvatarID());
                    $item->updateItem();
                    $avatar->addInventoryItem($itemID);
                    $avatar->updateAvatar();
                    return array("SUCCESS" => true);
                } else {
                    return array("ERROR" => 6);
                }
            } elseif ($item->getLocationID() === $avatar->getAvatarID()) {
                $item = new itemController($itemID);
                $item->setItemLocation("ground");
                $item->setLocationID($zone->getZoneID());
                $item->updateItem();
                $avatar->removeInventoryItem($itemID);
                $avatar->updateAvatar();
                return array("SUCCESS" => true);
            } else {
                return array("ERROR" => 3);
            }
        }
    }

    //This is used to find the name of a building based on the word used in the "View" and the ID used on the database
    public function buildingSearch($buildingName){
        switch ($buildingName){
            case "Chest":
                if (in_array("B0002",$this->zoneBuildings)){
                    return true;
                } else {
                    return false;
                }
                break;
            case "Firepit":
                if (in_array("B0001",$this->zoneBuildings)){
                    return true;
                } else {
                    return false;
                }

            default:
                return "ERROR";
        }
    }

    public static function updateOverallZoneExploration ($avatarID){
        $avatar = new avatarController($avatarID);
        $zoneController = new zoneController($avatar->getZoneID());
        $partyController = new partyController($avatar->getPartyID());
        if ($zoneController->getFindingChances()>0){
            $depleted = 1;
        } else {
            $depleted = 0;
        }
        $partyController->addOverallZoneExploration($zoneController->getZoneNumber(),$zoneController->getBiomeType(),$depleted);
        $partyController->uploadParty();
    }

    public static function destroyBiome($avatarID){
        $avatar = new avatarController($avatarID);
        if ($avatar->getStamina() < 5){
            return array("ERROR"=>0);
        } else {
            $zone = new zoneController($avatar->getZoneID());
            if ($zone->getProtectedType() !== "none") {
                return array("ERROR"=>59);
            } else {
                if ($zone->getFindingChances() < 1) {
                    return array("ERROR" => 4);
                } else {
                    $chances = floor($zone->getFindingChances() / 2);
                    $found = 0;
                    for ($x = 0; $x < $chances; $x++) {
                        $findingchance = self::findingChances($zone->getBiomeType(), $avatar->getFindingChanceFail());
                        if ($findingchance != 0) {
                            $itemID = self::addNewItem($zone->getBiomeType(), $zone->getMapID(), $zone->getZoneID());
                            if ($itemID != "ERROR") {
                                $found += 1;
                            }
                        }
                    }
                    $zone->setFindingChances(0);
                    $avatar->useStamina(5);
                    $avatar->addPlayStatistics("break", 5);
                    $avatar->updateAvatar();
                    $zone->updateZone();
                    $biome = new biomeTypeController($zone->getBiomeType());
                    chatlogMovementController::destroyBiome($avatarID);
                    return array("ALERT" => 6, "DATA" => array("foundItems" => $found, "biome" => $biome->getValue()));
                }
            }
        }
    }

    private static function addNewItem($biomeType,$mapID,$zoneID){
        $item = new itemController("");
        $biome = new biomeTypeController($biomeType);
        $item->createNewItem($biome->getValue(), $mapID,$zoneID,"ground");
        if ($item->getItemID() == ""){
            return "ERROR";
        }
        $item->insertItem();
        return $item->getItemID();
    }

    public static function worshipShrine($shrineID, $avatarID){
        $avatar = new avatarController($avatarID);
        $shrine = new shrineController($shrineID);
        if ($shrine->getZoneID() !== $avatar->getZoneID()){
            return array("ERROR"=>"Player is not in the correct location");
        } else{
            $checker = self::worshipChecker($avatar,$shrine);
            if ($checker === false){
                return array("ERROR"=>60);
            } else {
                $checker = self::worshipCoster($avatar,$shrine);
                if ($checker === "ERROR"){
                    return array("ERROR"=>"Something has gone wrong with the 'Worship Coster' function");
                } else {
                    $shrine->addCurrentArray($avatar->getAvatarID(),1);
                    $shrine->updateShrine();
                    return array("SUCCESS"=>true);
                }
            }
        }
    }

    private static function worshipChecker($avatar, $shrine){
        $check = false;
        switch ($shrine->getWorshipCostType()){
            case "Stamina":
                if ($avatar->getStamina() >= $shrine->getWorshipCostValue()){
                    $check = true;
                }
                break;
            case "Item":
                $itemList = itemController::getItemsAsObjects($avatar->getMapID(),"backpack",$avatar->getAvatarID());
                foreach ($itemList as $item){
                    if ($shrine->getWorshipCostValue() === $item->getItemTemplateID()){
                        $check = true;
                    }

                }
                break;
            case "ERROR":
                break;
            default:
                break;
        }
        return $check;
    }

    private static function worshipCoster($avatar,$shrine){
        $checker = "ERROR";
        switch ($shrine->getWorshipCostType()){
            case "Stamina":
                $avatar->useStamina($shrine->getWorshipCostValue());
                $avatar->updateAvatar();
                $checker = "SUCCESS";
                break;
            case "Item":
                $itemList = itemController::getItemsAsObjects($avatar->getMapID(),"backpack",$avatar->getAvatarID());
                foreach ($itemList as $item){
                    if ($shrine->getWorshipCostValue() === $item->getItemTemplateID()){
                        if ($checker === "ERROR"){
                            $checker = "SUCCESS";
                            $item->delete();
                            $avatar->removeInventoryItem($item->getItemID());
                            $avatar->updateAvatar();
                        }
                    }

                }
                break;
            case "ERROR":
                break;
            default:
                break;
        }
        return $checker;
    }

    public static function useRecipe($recipeID,$avatarID){
    $avatar = new avatarController($avatarID);
    $zoneInfo = itemController::getItemArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
    $recipe = new recipeController($recipeID);
    $zone = new zoneController($avatar->getZoneID());
    $tester = false;
    foreach ($zoneInfo as $item){
        if ($item["itemTemplateID"] == $recipe->getRequiredItems()){
            $tester = true;
        }
    }
    foreach ($zone->getBuildings() as $building){
        if ($building == $recipe->getRequiredBuildings()){
            $tester = true;
        }
    }
    if ($tester === false){
        return array("ERROR" => 12);
    } else {
        foreach ($recipe->getConsumedItems() as $requiredItem){
            $itemExists = false;
            $avatarItems = itemController::getItemArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
            foreach ($avatarItems as $backpackItem){
                if ($backpackItem["itemTemplateID"] == $requiredItem){
                    if ($itemExists === false) {
                        $itemExists = true;
                        $avatar->removeInventoryItem($backpackItem["itemID"]);
                    }
                }
            }
            if ($itemExists === false){
                $item = self::missingItemDetails($recipe->getConsumedItems());
                return array("ALERT" =>"2","DATA"=>$item);
            }
        }
        //Avatar is refreshed to allow a second run at removing of the items (for real this time)
        $avatar = new avatarController($avatarID);
        //Loop is repeated to actually remove the items from the game this time
        foreach ($recipe->getConsumedItems() as $requiredItem){
            $itemExistsNew = false;
            $avatarItems = itemController::getItemArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
            foreach ($avatarItems as $backpackItem){
                if ($backpackItem["itemTemplateID"] == $requiredItem){
                    if ($itemExistsNew === false) {
                        $itemExistsNew = true;
                        $itemToDelete = new itemController($backpackItem["itemID"]);
                        $itemToDelete->delete();
                        $avatar->removeInventoryItem($backpackItem["itemID"]);
                    }
                }
            }
        }
        //This then creates the new items
        $itemDetails = [];
        foreach ($recipe->getGeneratedItems() as $createdItem) {
            if ($createdItem === "I000X") {
                $createdItemName = recipeController::differentResult($recipe->getRecipeID());
                if (is_array($createdItemName)){
                    $avatar->useStamina(-5);
                    $avatar->updateAvatar();
                    return array("Success"=>true);
                }
            } else {
                $createdItemName = $createdItem;
            }
            $newItem = new itemController("");
            $newItem->createNewItemByID($createdItemName, $avatar->getMapID(),$avatar->getAvatarID(),"backpack");
            $newItem->insertItem();
            $avatar->addInventoryItem($newItem->getItemID());
            array_push($itemDetails,$newItem->getIdentity());
        }
        $avatar->updateAvatar();
        return array("ALERT"=>"1","DATA"=>$itemDetails);
    }
}


    /////VIEW INFORMATION////


    //This returns the playerMapController item for the avatars zone
    public static function getPlayerMapZoneController($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $party = new partyController($avatar->getPartyID());
        $biome = new biomeTypeController($zone->getBiomeType());
        return new playerMapZoneController($zone,$avatar,$party,$biome->getTemperatureMod());
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
            $tempZone = new PlayerMapZoneController($zone,$avatar,$party,0);
            $mapZones[$counter] = $tempZone->returnVars();
            $counter++;
        }
        $itemsView = $this->allItemsView($profileAvatar);
        $map = new mapController($avatar->getMapID());
        $logs = chatlogMovementController::getAllMovementLogs($avatar->getZoneID(),$party->getPlayersKnown(),$map->getCurrentDay(),$avatar->getAvatarID());
        $data = array("zone"=>$this->returnVars(),"mapZones"=>$mapZones,"itemsView"=>$itemsView,"logs"=>$logs);
        return $data;
    }

    //This returns the playerMapController item for any zone
    public static function getZoneInfo($zoneID, $avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($zoneID);
        $party = new partyController($avatar->getPartyID());
        return new PlayerMapZoneController($zone, $avatar,$party,0);
    }

    //This returns the playerMapController item for the avatars zone
    public static function getCurrentZoneInfo($avatarID)
    {
        playerMapZoneController::updateOverallZoneExploration($avatarID);
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $zone = new zoneController($avatar->getZoneID());
        $biome = new biomeTypeController($zone->getBiomeType());
        return new PlayerMapZoneController($zone, $avatar,$party,$biome->getTemperatureMod());
    }

    //This returns a view of just the backpack and the ground
    public function allItemsView($avatarID){
        $avatar = new avatarController($avatarID);
        $items = array("backpack" =>$this->getBackpackItems($avatar->getAvatarID()), "ground" => $this->getZoneItemsArray(), "avatar"=>$avatar->returnVars(),"recipes"=>$this->createRecipeList($avatar,$this->zoneBuildings));
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

    private static function missingItemDetails($itemList){
        $itemsArray = [];
        foreach ($itemList as $itemID) {
            $item = new itemController("");
            $item->createBlankItem($itemID);
            array_push($itemsArray,$item->returnVars());
        }
        return $itemsArray;
    }
}