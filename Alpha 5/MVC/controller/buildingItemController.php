<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class buildingItemController
{

    protected $materialRequired;
    protected $materialNeeded;
    protected $materialOwned;
    protected $identity;
    protected $description;
    protected $icon;

    function __construct($needed, $owned, $itemDetails)
    {
        $this->materialRequired = $itemDetails->getItemTemplateID();
        $this->materialNeeded = $needed;
        $this->materialOwned = $owned;
        $this->identity = $itemDetails->getIdentity();
        $this->description = $itemDetails->getDescription();
        $this->icon = $itemDetails->getIcon();
    }

    function __toString()
    {
        $output = $this->materialRequired;
        $output .= '/ ' . $this->materialNeeded;
        $output .= '/ ' . $this->materialOwned;
        $output .= '/ ' . $this->identity;
        $output .= '/ ' . $this->description;
        $output .= '/ ' . $this->icon;
        return $output;
    }

    function returnVars()
    {
        return get_object_vars($this);
    }

    ////////////////////ACTION FUNCTIONS/////////////////////////////

    //This transfers an item into the storage or back again
    public static function storageItemTransfer($itemIDpass, $avatarID)
    {
        $itemID = intval($itemIDpass);
        $item = new itemController($itemID);
        $avatar = new avatarController($avatarID);
        $storage = new storageController("", $avatar->getZoneID());
        if ($storage->getStorageID() == "") {
            return array("ERROR" => "No storage exists, please bug report this");
        } else {
            $storageLockID = buildingController::getConstructedBuildingID("StorageLock", $avatar->getZoneID());
            $storageLock = new buildingController($storageLockID);
            $zoneLockID = buildingController::getConstructedBuildingID("GateLock", $avatar->getZoneID());
            $zoneLock = new buildingController($zoneLockID);
            if ($zoneLock->getBuildingTemplateID() !== null) {
                if ($zoneLock->getStaminaSpent() === $zoneLock->getStaminaRequired() || $storageLock->getStaminaSpent() === $storageLock->getStaminaRequired()) {
                    $zone = new zoneController($avatar->getZoneID());
                    if ($zone->getControllingParty() !== null) {
                        if ($zone->getControllingParty() !== $avatar->getPartyID()) {
                            return array("ERROR" => 61);
                        }
                    } else {
                        return array("ERROR" => 62);
                    }
                }
            }
            if ($item->getLocationID() === $avatar->getAvatarID()) {
                if (count($storage->getItems()) >= $storage->getMaximumCapacity()) {
                    return array("ERROR" => 10);
                } else {
                    $avatar->removeInventoryItem($itemID);
                    $storage->addItem($itemID);
                    $item->setItemLocation("storage");
                    $item->setLocationID($storage->getStorageID());
                    chatlogStorageController::dropInStorage($avatarID, $item->getIdentity());
                }
            } else
                if ($item->getLocationID() === $storage->getStorageID()) {
                    if (count($avatar->getInventory()) >= $avatar->getMaxInventorySlots()) {
                        return array("ERROR" => 6);
                    } else {
                        $avatar->addInventoryItem($itemID);
                        $storage->removeItem($itemID);
                        $item->setItemLocation("backpack");
                        $item->setLocationID($avatar->getAvatarID());
                        chatlogStorageController::takeFromStorage($avatarID, $item->getIdentity());
                    }
                } else {
                    return array("ERROR" => 3);
                }
            $avatar->updateAvatar();
            $storage->uploadStorage();
            $item->updateItem();
            return array("Success");
        }
    }

    //This adds stamina to a building following the "build" button being clicked. It is built to allow any amount of stamina to be added but at the moment only uses 1
    public static function buildBuilding($id, $avatarID, $stamina)
    {
        $avatar = new avatarController($avatarID);
        if (($avatar->getStamina() - $stamina) < 0) {
            //Not enough stamina
            return array("ERROR" => 0);
        } else {
            $zone = new zoneController($avatar->getZoneID());
            if ($zone->getProtectedType() !== "none"){
                return array("ERROR"=>59);
            } else {
                $selectedBuilding = buildingItemController::getSingleBuilding($avatar->getAvatarID(),$id);
                if ($selectedBuilding->getIsBuilt() === true) {
                    //Building is already built
                    return array("ERROR" => 7);
                } elseif (!in_array($selectedBuilding->getBuildingTemplateID(), $avatar->getResearched())) {
                    //The player has not researched this building
                    return array("ERROR" => 39);
                } else {
                    if ($selectedBuilding->getCanBeBuilt() === false) {
                        //Building does not have enough materials to build it
                        return array("ERROR" => 8);
                    } else {
                        if (buildingItemController::checkBuildingAvailable($id,$zone->getZoneID()) === false) {
                            //Building cannot be built in this zone
                            return array("ERROR" => 65);
                        } else {
                            $parent = $selectedBuilding->getBuildingsRequired();
                            if ($parent !== "0") {
                                $parentBuilding = $selectedBuilding->checkBuildingBuilt($parent, $avatar->getZoneID());
                                if (array_key_exists("ERROR", $parentBuilding)) {
                                    //The parent building required to construct the building has not been built
                                    return array("ERROR" => 9);
                                }
                            }
                            if (($selectedBuilding->getStaminaSpent() + $stamina) > $selectedBuilding->getStaminaRequired()) {
                                $stamina = $selectedBuilding->getStaminaRequired() - $selectedBuilding->getStaminaSpent();
                            }
                            if ($selectedBuilding->getBuildingID() == "X") {
                                $newBuilding = new buildingController("");
                                $newBuilding->createNewBuilding($selectedBuilding->getBuildingTemplateID(), $avatar->getZoneID());
                            } else {
                                $newBuilding = new buildingController($selectedBuilding->getBuildingID());
                            }
                            $avatar->useStamina($stamina);
                            $avatar->addPlayStatistics("build", $stamina);
                            $response = achievementController::checkAchievement(array("ACTION","BUILD"));
                            if ($response !== false) {
                                $avatar->addAchievement($response);
                            }
                            $avatar->updateAvatar();
                            $newBuilding->addStaminaSpent($stamina);
                            $checker = null;
                            if ($newBuilding->getStaminaSpent() >= $newBuilding->getStaminaRequired()) {
                                $checker = self::completeBuilding($avatar, $selectedBuilding, $newBuilding);
                            }
                            $newBuilding->postBuildingDatabase();
                            if ($checker !== null) {
                                return $checker;
                            } else {
                                return array("SUCCESS");
                            }
                        }
                    }
                }
            }
        }
    }

    private static function completeBuilding($avatar, $buildingRequires,$newBuilding)
    {
        $zone = new zoneController($avatar->getZoneID());
        $storage = new storageController("", $zone->getZoneID());
        $itemsUsed = $buildingRequires->getItemsRequired();
        if ($zone->getStorage() == true) {
            $access = buildingItemController::storageAccess($avatar->getAvatarID());
            if ($access === true) {
                $zoneItems = itemController::getItemsAsObjects($zone->getMapID(),"storage",$storage->getStorageID());
            } else {
                $zoneItems = itemController::getItemsAsObjects($zone->getMapID(),"ground",$zone->getZoneID());
            }
        } else {
            $zoneItems = itemController::getItemsAsObjects($zone->getMapID(),"ground",$zone->getZoneID());
        }
        foreach ($itemsUsed as $material) {
            for ($x = 0; $x < $material["materialNeeded"]; $x++) {
                $removed = false;
                foreach ($zoneItems as $item) {
                    if ($removed == false) {
                        if ($material["materialRequired"] == $item->getItemTemplateID()) {
                            if ($zone->getStorage() == true) {
                                $storage->removeItem($item->getItemID());
                            }
                            $item->delete();
                            $removed = true;
                            $zoneItems[$item->getItemID()] = new itemController("");
                        }
                    }
                }
            }
        }
        $addBuilding = $buildingRequires->getBuildingTemplateID();
        if ($zone->getStorage() == true) {
            $storage->uploadStorage();
        }
        $newBuilding->setFuelRemaining($newBuilding->getFuelBuilding());
        $zone->addBuilding($addBuilding);
        chatlogZoneController::buildingCompleted($zone->getZoneID(),$newBuilding->getBuildingTemplateID());
        self::newBuildingFunctions($newBuilding, $zone,$avatar);
        $zone->updateZone();
        return array("ALERT"=>9,"DATA"=>$newBuilding->getName());
    }

    public static function firepitDrop($itemID, $avatarID)
    {
        $item = new itemController($itemID);
        $avatar = new avatarController($avatarID);
        if ($item->getLocationID() !== $avatar->getAvatarID()) {
            return array("ERROR" => 3);
        } else {
            $firepitBuilding = buildingController::getConstructedBuildingID("Firepit", $avatar->getZoneID());
            if (array_key_exists("ERROR",$firepitBuilding)) {
                return array("ERROR"=>33);
            } else {
                $protection = buildingController::getConstructedBuildingID("firepitCage",$avatar->getZoneID());
                $half = 1;
                if (is_object($protection) === true){
                    if ($protection->getStaminaRequired() === $protection->getStaminaSpent()){
                        $half = 2;
                    }
                }
                if ($item->getFuelValue() < 0){
                    $modVal = round($item->getFuelValue()/$half);
                    $firepitBuilding->modifyFuelRemaining($modVal);
                } else {

                    $firepitBuilding->modifyFuelRemaining($item->getFuelValue());
                }
                chatlogFirepitController::dropInFirepit($avatarID,$item->getItemID());
                $avatar->removeInventoryItem($itemID);
                $avatar->updateAvatar();
                $firepitBuilding->postBuildingDatabase();
                $item->delete();
                return self::firepitCheck($firepitBuilding->getBuildingID());
            }
        }
    }

    //This function is used to check a firepit and remove of it from the game if the fuel is too low
    public static function firepitCheck($firepitID)
    {
        $firepitBuilding = new buildingController($firepitID);
        if ($firepitBuilding->getFuelRemaining() <= 0) {
            $firepitBuilding->deleteBuilding();
            buildingItemController::smokeSignalsCheck($firepitBuilding->getZoneID());
            chatlogZoneController::firepitDepleted($firepitBuilding->getZoneID());
            $zone = new zoneController($firepitBuilding->getZoneID());
            $zone->removeBuilding($firepitBuilding->getBuildingTemplateID());
            $zone->updateZone();
            return array("ERROR" => 11);
        } else {
            return array("SUCCESS"=>true);
        }
    }

    //This function is used to check if the smoke signals building can be destroyed
    public static function smokeSignalsCheck($zoneID){
        $buildingID = buildingController::getConstructedBuildingID("Smoke",$zoneID);
        $smoke = new buildingController($buildingID);
        if ($smoke->getBuildingID() != ""){
            $firepitID = buildingController::getConstructedBuildingID("Firepit",$zoneID);
            $firepit = new buildingController($firepitID);
            if ($firepit->getBuildingID() != $firepitID){
                $smoke->deleteBuilding();
                $zone = new zoneController($zoneID);
                $zone->removeBuilding($smoke->getBuildingTemplateID());
                $zone->updateZone();
            }
        }
    }

    //This function is used to upgrade the storage building
    public static function upgradeStorage($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        if ($zone->getControllingParty() != null) {
            if ($avatar->getPartyID() != $zone->getControllingParty()) {
                return array("ERROR" => 32);
            }
        }
        $storage = new storageController($zone->getStorage(), $zone->getZoneID());
        if ($storage->getStorageID() == ""){
            return array("ERROR"=>33);
        } else {
            $upgradeItems = $storage->checkUpgradeCost();
            $deleteArray = [];
            foreach ($upgradeItems as $requirement => $number) {
                $counter = 1;
                $allItemsExist = false;
                $itemList = itemController::getItemArray($avatar->getMapID(), "storage", $storage->getStorageID());
                foreach ($itemList as $item) {
                    if ($allItemsExist === false) {
                        if ($requirement == $item["itemTemplateID"]) {
                            array_push($deleteArray, $item["itemID"]);
                            $storage->removeItem($item["itemID"]);
                            $counter++;
                            if ($counter > $number) {
                                $allItemsExist = true;
                            }
                        }
                    }
                }
                if ($allItemsExist === false) {
                    return array("ERROR" => 41);
                }
            }
            foreach ($deleteArray as $item) {
                $itemObject = new itemController($item);
                $itemObject->delete();
            }
            $storage->upgradeStorage();
            $storage->uploadStorage();
            chatlogStorageController::upgradeStorage($avatarID, $storage->getStorageLevel());
            return array("Success");
        }
    }

    //This defines the lock as the storage
    public static function impactLock($avatarID, $type,$building){
        if ($type==="break") {
            return self::breakLock($avatarID, $building);
        } elseif ($type==="reinforce"){
            return self::reinforceLock($avatarID, $building);
        } else{
            return array("ERROR"=>"x");
        }
    }

    //This function is used to remove stamina from the lock on a zone
    private static function breakLock($avatarID,$buildingName){
        $errorCheck = self::lockChecker($avatarID, $buildingName);
        if (array_key_exists("ERROR", $errorCheck) === true) {
            return $errorCheck;
        } else {
            $avatar = $errorCheck["avatar"];
            $zone = $errorCheck["zone"];
            $storageLock = $errorCheck["building"];
            if ($avatar->getPartyID() !== $zone->getControllingParty()) {
                    $avatar->useStamina(1);
                    $avatar->addPlayStatistics("break",1);
                    $avatar->updateAvatar();
                    $storageLock->modifyFuelRemaining(-1);
                    if ($storageLock->getFuelRemaining() < 1){
                        $zone->removeBuilding($storageLock->getBuildingTemplateID());
                        $zone->updateZone();
                        chatlogZoneController::lockDestroyed($zone->getZoneID(),$storageLock->getBuildingTemplateID());
                        $storageLock->deleteBuilding();
                        return array("ERROR" => 35);
                    }
                    $storageLock->postBuildingDatabase();
                    return array("Success");
            } else {
                return array("ERROR" => 34);
            }
        }
    }

    //This functon is used to add stamina to a storage lock in a zone
    public static function reinforceLock($avatarID,$buildingName)
    {
        $errorCheck = self::lockChecker($avatarID, $buildingName);
        if (array_key_exists("ERROR", $errorCheck) === true) {
            return $errorCheck;
        } else {
            $avatar = $errorCheck["avatar"];
            $zone = $errorCheck["zone"];
            $storageLock = $errorCheck["building"];
            if ($avatar->getPartyID() == $zone->getControllingParty()) {
                $maximum =  buildingController::lockTotal($storageLock);
                if ($storageLock->getFuelRemaining() < $maximum) {
                    $avatar->useStamina(1);
                    $avatar->addPlayStatistics("build",1);
                    $avatar->updateAvatar();
                    $storageLock->modifyFuelRemaining(1);
                    $storageLock->postBuildingDatabase();
                    return array("Success");
                } else {
                    return array("ERROR" => 36);
                }
            } else {
                return array("ERROR" => 34);
            }
        }
    }

    //This is the generic function used for the majority of error checking when performing an action on a lock
    private static function lockChecker($avatarID, $buildingName){
        $avatar = new avatarController($avatarID);
        $check = buildingController::checkIfLock($buildingName);
        if ($check === true) {
            $lock = buildingController::findBuildingInZone($buildingName, $avatar->getZoneID());
            if (array_key_exists("ERROR", $lock) !== true) {
                $zone = new zoneController($avatar->getZoneID());
                if ($lock->getStaminaSpent() === $lock->getStaminaRequired()) {
                    if ($lock->getFuelRemaining() > 0) {
                        if ($avatar->getStamina() > 0) {
                            return array("avatar" => $avatar, "building" => $lock, "zone" => $zone);
                        } else {
                            return array("ERROR" => 0);
                        }
                    } else {
                        $zone->removeBuilding($lock->getBuildingTemplateID());
                        $zone->updateZone();
                        $lock->deleteBuilding();
                        return array("ERROR" => 9);
                    }
                } else {
                    return array("ERROR" => 33);
                }
            } else {
                return $lock;
            }
        }
        else {
            return array("ERROR"=>"This should not be possible, the wrong building id has occured. Please error report");
        }
    }

    //This function upgrades the players sleepingbag
    public static function upgradeSleepingBag($avatarID){
        $avatar = new avatarController($avatarID);
        $sleepingBagItems = buildingLevels::sleepingBagUpgradeCost($avatar->getTempModLevel());
        $deleteArray = [];
        foreach ($sleepingBagItems as $requirement => $number) {
            $counter = 1;
            $allItemsExist = false;
            $itemList = itemController::getItemsAsObjects($avatar->getMapID(),"backpack",$avatar->getAvatarID());
            foreach ($itemList as $item) {
                if ($allItemsExist === false) {
                    if ($requirement == $item->getItemTemplateID()) {
                        array_push($deleteArray, $item->getItemID());
                        $avatar->removeInventoryItem($item->getItemID());
                        $item->delete();
                        $counter++;
                        if ($counter > $number) {
                            $allItemsExist = true;
                        }
                    }
                }
            }
            if ($allItemsExist === false) {
                return array("ERROR" => 42);
            }
        }
        foreach ($deleteArray as $item) {
            $itemObject = new itemController($item);
            $itemObject->delete();
        }
        $avatar->setTempModLevel($avatar->getTempModLevel()+1);
        chatlogPersonalController::upgradeSleepingBag($avatar->getAvatarID(),$avatar->getTempModLevel());
        $avatar->updateAvatar();
        return array("SUCCESS"=>true);
    }

    //This function upgrades the players backpack
    public static function upgradeBackpack($avatarID){
        $avatar = new avatarController($avatarID);
        $backpackItems = buildingLevels::backpackUpgradeCost($avatar->getMaxInventorySlots());
        $deleteArray = [];
        foreach ($backpackItems as $requirement => $number) {
            $counter = 1;
            $allItemsExist = false;
            $itemList = itemController::getItemsAsObjects($avatar->getMapID(),"backpack",$avatar->getAvatarID());
            foreach ($itemList as $item) {
                if ($allItemsExist === false) {
                    if ($requirement == $item->getItemTemplateID()) {
                        array_push($deleteArray, $item->getItemID());
                        $avatar->removeInventoryItem($item->getItemID());
                        $item->delete();
                        $counter++;
                        if ($counter > $number) {
                            $allItemsExist = true;
                        }
                    }
                }
            }
            if ($allItemsExist === false) {
                return array("ERROR" => 42);
            }
        }
        foreach ($deleteArray as $item) {
            $itemObject = new itemController($item);
            $itemObject->delete();
        }
        $avatar->setMaxInventorySlots($avatar->getMaxInventorySlots()+1);
        chatlogPersonalController::upgradeBackpack($avatar->getAvatarID(),$avatar->getMaxInventorySlots());
        $avatar->updateAvatar();
        return array("SUCCESS"=>true);
    }

    //This function adds to the players research counter
    public static function performResearch($avatarID){
        $checker = self::getAvailableResearchOptions($avatarID,"check");
        if ($checker === false){
            return array("ERROR"=>40);
        } else {
            $avatar = new avatarController($avatarID);
        }
        if ($avatar->getStamina() <= 0){
            return array("ERROR"=>0);
        } else{
            if ($avatar->getResearchStatsStamina() >= buildingLevels::researchStaminaLevels($avatar->getResearchStatsLevel())){
                return array("ERROR"=>"Please choose a research");
            } else {
                $avatar->adjustResearchStatsStamina(1);
                $avatar->useStamina(1);
                $avatar->addPlayStatistics("research",1);
                $response = achievementController::checkAchievement(array("ACTION","RESEARCH"));
                if ($response !== false) {
                    $avatar->addAchievement($response);
                }
                $avatar->updateAvatar();
                return array("SUCCESS"=>true);
            }
        }
    }

    //This function finds the researched buildings that aren't known to a player and the types left to research
    public static function getAvailableResearchOptions($avatarID,$type){
        $list = buildingController::getAllBuildings();
        $avatar = new avatarController($avatarID);
        $unknownList = [];
        $unknownTypeList = [];
        foreach ($list as $building){
            if (!in_array($building->getBuildingTemplateID(),$avatar->getResearched())){
                array_push($unknownList,$building->getBuildingTemplateID());
                if (!in_array($building->getBuildingTypeID(),$unknownTypeList)){
                    array_push($unknownTypeList,$building->getBuildingTypeID());
                }
            }
        }
        if ($type === "check"){
            if (count($unknownList) > 0){
                return true;
            } else{
                return false;
            }
        } else if ($type === "view") {
            $final = [];
            foreach ($unknownTypeList as $type) {
                $temp = new buildingType($type);
                $final[$type] = $temp->returnVars();
            }
            return $final;
        } else {
            $final = [];
            foreach ($list as $building){
                if (!in_array($building->getBuildingTemplateID(),$avatar->getResearched())) {
                    if ($building->getBuildingTypeID() === $type) {
                        array_push($final, $building->getBuildingTemplateID());
                    }
                }
            }
            return $final;
        }
    }

    //This function finds the player a new researched building
    public static function completeResearch($avatarID,$type)
    {
        $avatar = new avatarController($avatarID);
        if ($avatar->getResearchStatsStamina() < buildingLevels::researchStaminaLevels($avatar->getResearchStatsLevel())) {
            return array("ERROR"=>"You have not completed your research yet");
        } else {
            $checker = self::getAvailableResearchOptions($avatarID,"check");
            if ($checker === false){
                return array("ERROR"=>40);
            }
            else {
                $list = self::getAvailableResearchOptions($avatarID,$type);
                if (count($list) > 0){
                    $buildingFound = rand(0, (count($list) - 1));
                    if (in_array($list[$buildingFound], $avatar->getResearched())) {
                        return array("ERROR" => "This research is already known");
                    } else {
                        $avatar->adjustResearchStatsLevel(1);
                        $avatar->setResearchStats(1, 0);
                        $avatar->addResearched($list[$buildingFound]);
                        $building = new buildingController("");
                        $building->createNewBuilding($list[$buildingFound], $avatar->getZoneID());
                        chatlogPersonalController::findNewResearch($avatar->getAvatarID(), $building->getName());
                        $avatar->updateAvatar();
                        return array("ALERT" => 3, "DATA" => array("researchName" => $building->getName(), "researchIcon" => $building->getIcon(), "researchDescription" => $building->getDescription()));
                    }
                } else {
                    return array("ERROR"=>40);
                }
            }
        }
    }


    ///////////////////////VIEW FUNCTIONS//////////////////////

    function createBuildingItems($itemID, $needed, $owned)
    {
        return array("Item" => $itemID, "needed" => $needed, "owned" => $owned);
    }

    //This creates the building object with the items required to construct it converted into "items" from the item table
    public static function checkItems($avatarID)
    {
        $itemsArray = itemController::getAllItems();
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $buildingController = new buildingController("");
        $buildingsList = $buildingController->getBuildingsArray($avatar->getZoneID());
        foreach ($buildingsList as $key=>$buildings){
            if ($buildings->getStaminaSpent() < $buildings->getStaminaRequired()){
                if (!in_array($buildings->getBuildingTemplateID(),$avatar->getResearched())) {
                    unset($buildingsList[$key]);
                }
                if (self::checkBuildingAvailable($buildings->getBuildingTemplateID(),$zone->getZoneID()) === false){
                    unset($buildingsList[$key]);
                }
            }
        }
        if ($zone->getStorage() == true) {
            $access = buildingItemController::storageAccess($avatarID);
            if ($access === true) {
                $storage = new storageController("", $zone->getZoneID());
                $zoneItems = itemController::getItemArray($avatar->getMapID(), "storage", $storage->getStorageID());
            } else {
                $zoneItems = itemController::getItemArray($zone->getMapID(),"ground",$zone->getZoneID());
            }
        } else {
            $zoneItems = itemController::getItemArray($zone->getMapID(),"ground",$zone->getZoneID());
        }
        foreach ($buildingsList as $building) {
            $materials = [];
            $materialsRequired = $building->getItemsRequired();
            foreach ($materialsRequired as $resource => $required) {
                $counter = 0;
                foreach ($zoneItems as $singleItem) {
                    if ($singleItem["itemTemplateID"] == $resource) {
                        $counter += 1;
                    }
                }
                $itemIdentity = "";
                foreach ($itemsArray as $itemDetails) {
                    if ($itemDetails->getItemTemplateID() == $resource) {
                        $itemIdentity = $itemDetails;
                    }
                }
                $tempItem = new buildingItemController($required, $counter, $itemIdentity);
                $materials[$tempItem->materialRequired] = $tempItem->returnVars();
            }
            $building->setItemsRequired($materials);
            $building->checkCanBeBuilt();

        }
        foreach ($buildingsList as $name => $building) {
            $buildingsList[$name] = $building->returnVars();
        }
        return $buildingsList;
    }

    //This returns a single buildings details including the item required to build it converted into items from the item table
    private function getSingleBuilding($avatarID, $buildingID)
    {
        $itemsArray = itemController::getAllItems();
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $tempID = buildingController::findBuildingInZone($buildingID, $avatar->getZoneID());
        if (array_key_exists("ERROR",$tempID)){
            $building = new buildingController("");
            $building->createNewBuilding($buildingID,$zone->getZoneID());
        } else {
            $building = new buildingController($tempID);
        }
        if ($zone->getStorage() == true) {
            $access = buildingItemController::storageAccess($avatar->getAvatarID());
            if ($access === true) {
                $storage = new storageController("", $zone->getZoneID());
                $zoneItems = itemController::getItemArray($avatar->getMapID(), "storage", $storage->getStorageID());
            } else {
                $zoneItems = itemController::getItemArray($zone->getMapID(), "ground", $zone->getZoneID());
            }
        } else {
            $zoneItems = itemController::getItemArray($zone->getMapID(), "ground", $zone->getZoneID());
        }
        if ($building->getBuildingTemplateID() == $buildingID) {
            $materials = [];
            $materialsRequired = $building->getItemsRequired();
            foreach ($materialsRequired as $resource => $required) {
                $counter = 0;
                foreach ($zoneItems as $singleItem) {
                    if ($singleItem["itemTemplateID"] == $resource) {
                        $counter += 1;
                    }
                }
                $itemIdentity = "";
                foreach ($itemsArray as $itemDetails) {
                    if ($itemDetails->getItemTemplateID() == $resource) {
                        $itemIdentity = $itemDetails;
                    }
                }
                $tempItem = new buildingItemController($required, $counter, $itemIdentity);
                $materials[$tempItem->materialRequired] = $tempItem->returnVars();
            }
            $building->setItemsRequired($materials);
            $building->checkCanBeBuilt();
            return $building;
        }
        return "ERROR";
    }

    public static function storageAccess($avatarID){
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        if ($zone->getControllingParty() !== null && $zone->getControllingParty() !== $avatar->getPartyID()) {
            $storageLock = buildingController::getConstructedBuildingID("StorageLock", $zone->getZoneID());
            if (array_key_exists("ERROR", $storageLock) !== true) {
                if ($storageLock->getStaminaSpent() === $storageLock->getStaminaRequired()) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function returnZoneStorage($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $storage = new storageController("", $avatar->getZoneID());
        $party = new partyController($avatar->getPartyID());
        $map = new mapController($avatar->getMapID());
        $backpack = itemController::getItemArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
        if ($storage->getStorageID() == "") {
            $storageItems = array("ERROR" => 7);
        } else {
            $storageItems = itemController::getItemArray($avatar->getMapID(),"storage",$storage->getStorageID());
        }
        $upgrade = $storage->checkUpgradeCost();
        $itemsArray = [];
        foreach ($upgrade as $item => $count) {
            $itemObject = new itemController("");
            $itemObject->createBlankItem($item);
            for ($x = 0; $x < $count; $x++) {
                $itemsArray[$itemObject->getIdentity() . $x] = $itemObject->returnVars();
            }

        }
        $logs = chatlogStorageController::getAllStorageLogs($avatar->getZoneID(),$party->getPlayersKnown(),$map->getCurrentDay(),$avatar->getAvatarID());
        $storageLock = buildingController::getConstructedBuildingID("StorageLock",$avatar->getZoneID());
        $lock = false;
        $access = true;
        $total = false;
        if (array_key_exists("ERROR",$storageLock) !== true){
            $total = buildingController::lockTotal($storageLock);
            $zone = new zoneController($avatar->getZoneID());
            if ($storageLock->getStaminaSpent() === $storageLock->getStaminaRequired()) {
                $lock = $storageLock->getFuelRemaining();
                if ($avatar->getPartyID() != $zone->getControllingParty()) {
                    $access = false;
                }
            }
        }
        return array("backpack" => $backpack, "storageItems" => $storageItems, "avatar" => $avatar->returnVars(), "lock"=>array("access"=>$access,"current"=>$lock,"total"=>$total), "storage1" => $storage->returnVars(), "upgrade" => $itemsArray, "logs"=>$logs);
    }

    public static function returnFirepitData($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $party = new partyController($avatar->getPartyID());
        $map = new mapController($avatar->getMapID());
        $backpack = itemController::getItemArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
        $firepitBuilding = buildingController::getConstructedBuildingID("Firepit", $avatar->getZoneID());
        $logs = chatlogFirepitController::getAllFirepitLogs($avatar->getZoneID(),$party->getPlayersKnown(),$map->getCurrentDay(),$avatar->getAvatarID());
        if (array_key_exists("ERROR", $firepitBuilding)) {
            $firepit = array("ALERT"=>4);
        } else {
            if ($firepitBuilding->getStaminaRequired() === $firepitBuilding->getStaminaSpent()) {
                $firepitController = new firepitController($firepitBuilding);
                $firepit = $firepitController->returnVars();
            } else {
                $firepit = array("ALERT" => 4);
            }
        }
        if(array_key_exists("ALERT",$firepit)){
            return array("DATA"=>array("backpack" => $backpack, "backpackSize" => $avatar->getMaxInventorySlots(), "logs" => $logs), "ALERT" => $firepit["ALERT"]);
        } else {
            return array("backpack" => $backpack, "backpackSize" => $avatar->getMaxInventorySlots(), "firepit" => $firepit, "logs" => $logs);
        }
    }

    public static function getZoneOverviewBuildings($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        return array("zone" => $zone->returnVars());
    }


//////////////////////THIS NEED TO BE CHANGED IF BUILDING ID'S CHANGE /////////////////////////

    private static function newBuildingFunctions($completedBuilding, $zoneItem,$avatarItem)
    {
        $buildingID = $completedBuilding->getBuildingTemplateID();
        switch ($buildingID) {
            case "B0002":
                $storage = new storageController("", "");
                $storage->createStorage($zoneItem->getZoneID(), "10");
                $zoneItem->setStorage(1);
                $storage->insertStorage();
                break;
            case "B0003":
                $zoneItem->setControllingParty($avatarItem->getPartyID());
                $zoneItem->setZoneOutpostName(nameGeneratorController::getNameAsText("camp"));
                break;
            case "B0006":
                $zoneItem->setControllingParty($avatarItem->getPartyID());
                $zoneItem->removeBuilding($buildingID);
                $completedBuilding->setStaminaSpent(0);
                break;
            case "B0009":
                $gate = buildingController::getConstructedBuildingID("GateLock",$completedBuilding->getZoneID());
                $gate->modifyFuelRemaining($completedBuilding->getFuelBuilding());
                $gate->postBuildingDatabase();
                break;
            default:
                break;
        }
    }

    private static function checkBuildingAvailable($buildingType,$zoneID){
        switch ($buildingType){
            case "B0012":
                $zone = new zoneController($zoneID);
                if ($zone->getBiomeType() >0 && $zone->getBiomeType() <4){
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return true;
                break;
        }
    }



}