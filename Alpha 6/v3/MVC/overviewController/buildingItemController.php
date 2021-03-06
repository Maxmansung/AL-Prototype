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
            $zone = new zoneController($avatar->getZoneID());
            if ($zone->getLockStrength() > 0 || $storage->getLockStrength() > 0) {
                if ($zone->getControllingParty() !== $avatar->getPartyID()) {
                    return array("ERROR" => 61);
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
                    $map = new mapController($avatar->getMapID());
                    chatlogStorageController::dropInStorage($avatar, $item->getIdentity(), $map->getCurrentDay());
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
                        $map = new mapController($avatar->getMapID());
                        chatlogStorageController::takeFromStorage($avatar, $item->getIdentity(), $map->getCurrentDay());
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

    //This picks up an item from the chest


    //This function is used to convert the template into an item when picking up
    public static function pickItem($tempItemID, $avatarID)
    {
        $tempClean = preg_replace(data::$cleanPatterns['text'], "", $tempItemID);
        $avatar = new avatarController($avatarID);
        $storage = new storageController("", $avatar->getZoneID());
        $id = itemModel::getItemIDsFromLocationGround($avatar->getMapID(), "storage", $storage->getStorageID(), $tempClean);
        $item = new itemController($id);
        if ($storage->getStorageID() == "") {
            return array("ERROR" => "No storage exists, please bug report this");
        } else {
            $zone = new zoneController($avatar->getZoneID());
            if ($zone->getLockStrength() > 0 || $storage->getLockStrength() > 0) {
                if ($zone->getControllingParty() !== $avatar->getPartyID()) {
                    return array("ERROR" => 61);
                }
            }
            if ($item->getLocationID() === $storage->getStorageID()) {
                if (count($avatar->getInventory()) >= $avatar->getMaxInventorySlots()) {
                    return array("ERROR" => 6);
                } else {
                    $avatar->addInventoryItem($item->getItemID());
                    $storage->removeItem($item->getItemID());
                    $item->setItemLocation("backpack");
                    $item->setLocationID($avatar->getAvatarID());
                    $map = new mapController($avatar->getMapID());
                    chatlogStorageController::takeFromStorage($avatar, $item->getIdentity(), $map->getCurrentDay());
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
    public static function buildBuilding($avatarID, $location, $id, $stamina)
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
                $selectedBuilding = buildingItemController::getSingleBuilding($avatar,$id,$location);
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
                                $checker = self::completeBuilding($avatar,$zone, $selectedBuilding, $newBuilding,$location);
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

    private static function completeBuilding($avatar,$zone, $buildingRequires,$newBuilding,$type)
    {
        $itemsUsed = $buildingRequires->getItemsRequired();
        if ($type === "backpack"){
            $zoneItems = itemController::getItemsAsObjects($avatar->getMapID(), "backpack", $avatar->getAvatarID());
        } elseif ($type === "storage"){
            $storage = new storageController("", $zone->getZoneID());
            $zoneItems = itemController::getItemsAsObjects($avatar->getMapID(), "storage", $storage->getStorageID());
        } else {
            $zoneItems = itemController::getItemsAsObjects($avatar->getMapID(), "ground", $zone->getZoneID());
        }
        foreach ($itemsUsed as $material) {
            for ($x = 0; $x < $material["materialNeeded"]; $x++) {
                $removed = false;
                foreach ($zoneItems as $item) {
                    if ($removed == false) {
                        if ($material["materialRequired"] == $item->getItemTemplateID()) {
                            if ($type === "storage") {
                                $storage->removeItem($item->getItemID());
                            } elseif ($type === "backpack"){
                                $avatar->removeInventoryItem($item->getItemID());
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
        if ($type === "storage") {
            $storage->uploadStorage();
        }
        $newBuilding->setFuelRemaining($newBuilding->getFuelBuilding());
        $zone->addBuilding($addBuilding);
        $map = new mapController($zone->getMapID());
        chatlogZoneController::buildingCompleted($zone,$newBuilding->getBuildingTemplateID(),$map->getCurrentDay());
        $zone = self::newBuildingFunctions($newBuilding,$zone,$avatar);
        $zone->updateZone();
        return array("ALERT"=>32,"DATA"=>$newBuilding->getName());
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

    //This defines the lock as the storage
    public static function impactLock($avatarID,$building)
    {
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        if ($zone->getControllingParty() != 0) {
            if ($zone->getControllingParty() === $avatar->getPartyID()) {
                return self::reinforceLock($avatar,$zone,$building);
            } else {
                return self::breakLock($avatar,$zone,$building);
            }
        } else {
            return array("ERROR" => "This zone does not have a lock, please error report this");
        }
    }

    //This function is used to remove stamina from the lock on a zone
    private static function breakLock($avatar,$zone,$buildingName)
    {
        if ($buildingName === "Chest") {
            $storage = new storageController("", $zone->getZoneID());
            $checker = self::lockChecker($avatar, $zone, $storage,true);
        } else {
            $checker = self::lockChecker($avatar, $zone, "",false);
        }
        if ($checker == false) {
            $avatar->useStamina(1);
            $avatar->addPlayStatistics("break", 1);
            $avatar->updateAvatar();
            if ($buildingName === "Chest") {
                $temp = $storage->getLockStrength();
                $temp--;
                $storage->setLockStrength($temp);
                $storage->uploadStorage();
            } else {
                $temp = $zone->getLockStrength();
                $temp--;
                $zone->setLockStrength($temp);
                $zone->updateZone();
            }
            return array("SUCCESS" => True);
        } else {
            return array("ERROR" => 34);
        }
    }

    //This functon is used to add stamina to a storage lock in a zone
    public static function reinforceLock($avatar,$zone,$buildingName)
    {
        if ($buildingName === "Chest") {
            $storage = new storageController("", $zone->getZoneID());
            $checker = self::lockChecker($avatar, $zone, $storage,true);
        } else {
            $checker = self::lockChecker($avatar, $zone, "",false);
        }
        if ($checker == true) {
            if ($buildingName === "Chest") {
                if ($storage->getLockStrength() < $storage->getLockMax()) {
                    $avatar->useStamina(1);
                    $avatar->addPlayStatistics("build", 1);
                    $avatar->updateAvatar();
                    $temp = $storage->getLockStrength();
                    $temp++;
                    $storage->setLockStrength($temp);
                    $storage->uploadStorage();
                    return array("SUCCESS");
                } else {
                    return array("ERROR" => "This lock cannot be repaired further");
                }
            } else {
                if ($zone->getLockStrength() < $zone->getLockMax()) {
                    $avatar->useStamina(1);
                    $avatar->addPlayStatistics("build", 1);
                    $avatar->updateAvatar();
                    $temp = $zone->getLockStrength();
                    $temp++;
                    $zone->setLockStrength($temp);
                    $zone->updateZone();
                    return array("SUCCESS");
                } else {
                    return array("ERROR" => "This lock cannot be repaired further");
                }
            }
        } else {
            return array("ERROR" => 34);
        }
    }

    //This is the generic function used for the majority of error checking when performing an action on a lock
    public static function lockChecker($avatar,$zone,$storage,$chest){
        $access = true;
        if ($zone->getControllingParty() == $avatar->getPartyID()){
            return $access;
        } else {
            if ($zone->getLockBuilt() > 0){
                if ($zone->getLockStrength() > 0){
                    $access = false;
                }
            }
            if ($chest === true){
                if ($storage->getLockBuilt() > 0){
                    if ($storage->getLockStrength() > 0){
                        $access = false;
                    }
                }
            }
            return $access;
        }
    }

    //This function upgrades the players backpack
    public static function upgradeBackpack($avatarID,$type){
        $avatar = new avatarController($avatarID);
        $typeClean = intval(preg_replace(data::$cleanPatterns['num'],"",$type));
        $backpackUpgrade = "equipment".$typeClean;
        $backpackController = new $backpackUpgrade();
        $currentClass = "equipment".$avatar->getTempModLevel();
        $currentBackpack = new $currentClass();
        if ($currentBackpack->getUpgrade1() !== $typeClean && $currentBackpack->getUpgrade2() !== $typeClean){
            return array("ERROR"=>"The backpack upgrade has failed: ".$currentBackpack->getUpgrade1()." / ".$typeClean);
        } else {
            $itemList = itemController::getItemsAsObjects($avatar->getMapID(), "backpack", $avatar->getAvatarID());
            $tempList = $itemList;
            $counter = [];
            for ($x = 0;$x < $backpackController->getCost1Count(); $x++){
                $checker = false;
                foreach ($tempList as $key=>$item){
                    if ($checker === false){
                        if ($item->getItemTemplateID() === $backpackController->getCost1Item()){
                            array_push($counter,$item->getItemID());
                            $checker = $key;
                        }
                    }
                }
                if ($checker === false){
                    return array("ERROR"=>"There are not the correct items in your bag");
                } else {
                    unset($tempList[$checker]);
                }
            }
            //Now we do it for real...
            foreach ($counter as $id){
                $avatar->removeInventoryItem($id);
                $itemList[$id]->delete();
            }
            $avatar->setTempModLevel($typeClean);
            //This is used to reset the temperature bonus and give the new temperature bonus
            $resetTemp = $avatar->getAvatarSurvivableTemp();
            $resetTemp = $resetTemp-$currentBackpack->getHeatBonus();
            $resetTemp = $resetTemp+$backpackController->getHeatBonus();
            $resetSize = $avatar->getMaxInventorySlots();

            //This is used to reset the backpack size bonus and give the new backpack size
            $avatar->setAvatarSurvivableTemp($resetTemp);
            $resetSize = $resetSize-$currentBackpack->getBackpackBonus();
            $resetSize = $resetSize+$backpackController->getBackpackBonus();
            $avatar->setMaxInventorySlots($resetSize);

            $map = new mapController($avatar->getMapID());
            chatlogPersonalController::upgradeBackpack($avatar, $backpackController->getEquipName(),$map->getCurrentDay());
            $avatar->updateAvatar();
            return array("SUCCESS" => true);
        }
    }

    //This function adds to the players research counter
    public static function performResearch($avatarID){
        $avatar = new avatarController($avatarID);
        $checker = self::getAvailableResearchOptions($avatar,"check");
        if ($checker === false){
            return array("ERROR"=>40);
        } else {
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
    public static function getAvailableResearchOptions($avatar,$type){
        $list = buildingController::getAllBuildings();
        $unknownList = [];
        $unknownTypeList = [];
        foreach ($list as $building){
            $checker = true;
            if ($building->getBuildingsRequired() != 0) {
                if (!in_array($unknownList, $building->getBuildingsRequired())) {
                    $checker = false;
                }
            }
            if ($checker === true) {
                if (!in_array($building->getBuildingTemplateID(), $avatar->getResearched())) {
                    array_push($unknownList, $building->getBuildingTemplateID());
                    if (!in_array($building->getBuildingTypeID(), $unknownTypeList)) {
                        array_push($unknownTypeList, $building->getBuildingTypeID());
                    }
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
        $typeClean = intval(preg_replace(data::$cleanPatterns['num'],"",$type));
        $avatar = new avatarController($avatarID);
        if ($avatar->getResearchStatsStamina() < buildingLevels::researchStaminaLevels($avatar->getResearchStatsLevel())) {
            return array("ERROR"=>"You have not completed your research yet");
        } else {
            $list = self::getAvailableResearchOptions($avatar,$typeClean);
            if (count($list) < 1){
                return array("ERROR"=>40);
            }
            else {
                $buildingFound = rand(0, (count($list) - 1));
                if (in_array($list[$buildingFound], $avatar->getResearched())) {
                    return array("ERROR" => "This research is already known");
                } else {
                    $avatar->adjustResearchStatsLevel(1);
                    $avatar->setResearchStats(1, 0);
                    $avatar->addResearched($list[$buildingFound]);
                    $building = new buildingController("");
                    $building->createNewBuilding($list[$buildingFound], $avatar->getZoneID());
                    $map = new mapController($avatar->getMapID());
                    chatlogPersonalController::findNewResearch($avatar, $building->getName(),$map->getCurrentDay());
                    $avatar->updateAvatar();
                    return array("ALERT" => 12, "DATA" => array("researchName" => $building->getName(), "researchIcon" => $building->getIcon(), "researchDescription" => $building->getDescription()));
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
    public static function checkItems($avatar,$type)
    {
        $itemsArray = itemController::getAllItems();
        $zone = new zoneController($avatar->getZoneID());
        $buildingsList = buildingController::getBuildingsArray($avatar->getZoneID());
        foreach ($buildingsList as $key => $buildings) {
            if ($buildings->getStaminaSpent() < $buildings->getStaminaRequired()) {
                if (!in_array($buildings->getBuildingTemplateID(), $avatar->getResearched())) {
                    unset($buildingsList[$key]);
                }
                if (self::checkBuildingAvailable($buildings->getBuildingTemplateID(), $zone->getZoneID()) === false) {
                    unset($buildingsList[$key]);
                }
            }
        }
        $access = buildingItemController::storageAccess($avatar->getAvatarID());
        if ($access === true) {
            $storage = new storageController("", $zone->getZoneID());
        } else {
            $storage = new storageController("", "");
        }
        if ($type === "backpack"){
            $zoneItems = itemController::getItemArray($avatar->getMapID(), "backpack", $avatar->getAvatarID());
        } elseif ($type === "storage"){
            $zoneItems = itemController::getItemArray($avatar->getMapID(), "storage", $storage->getStorageID());
        } else {
            $zoneItems = itemController::getItemArray($avatar->getMapID(), "ground", $zone->getZoneID());
        }
        foreach ($buildingsList as $building) {
            $materials = [];
            $materialsRequired = $building->getItemsRequired();
            foreach ($materialsRequired as $resource => $required) {
                $counter = 0;
                foreach ($zoneItems as $singleItem) {
                    if ($singleItem->getItemTemplateID() == $resource) {
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
            if ($building->getBuildingsRequired() === "0"){
                $building->setParentBuilt(true);
            } else {
                $temp = $buildingsList[$building->getBuildingsRequired()];
                if ($temp->getStaminaSpent() >= $temp->getStaminaRequired()) {
                    $building->setParentBuilt(true);
                } else {
                    $building->setParentBuilt(false);
                }
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
    private static function getSingleBuilding($avatar,$buildingID,$type)
    {
        $itemsArray = itemController::getAllItems();
        $zone = new zoneController($avatar->getZoneID());
        $tempID = buildingController::findBuildingInZone($buildingID, $avatar->getZoneID());
        if (array_key_exists("ERROR",$tempID)){
            $building = new buildingController("");
            $building->createNewBuilding($buildingID,$zone->getZoneID());
        } else {
            $building = new buildingController($tempID);
        }
        $access = buildingItemController::storageAccess($avatar->getAvatarID());
        if ($access === true) {
            $storage = new storageController("", $zone->getZoneID());
        } else {
            $storage = new storageController("", "");
        }
        if ($type === "backpack"){
            $zoneItems = itemController::getItemArray($avatar->getMapID(), "backpack", $avatar->getAvatarID());
        } elseif ($type === "storage"){
            $zoneItems = itemController::getItemArray($avatar->getMapID(), "storage", $storage->getStorageID());
        } else {
            $zoneItems = itemController::getItemArray($avatar->getMapID(), "ground", $zone->getZoneID());
        }
        if ($building->getBuildingTemplateID() == $buildingID) {
            $materials = [];
            $materialsRequired = $building->getItemsRequired();
            foreach ($materialsRequired as $resource => $required) {
                $counter = 0;
                foreach ($zoneItems as $singleItem) {
                    if ($singleItem->getItemTemplateID() == $resource) {
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
            if ($building->getBuildingsRequired() == 0){
                $building->setParentBuilt(true);
            } else {
                $temp = new buildingController($building->getBuildingsRequired());
                if ($temp->getStaminaSpent() >= $temp->getStaminaRequired()) {
                    $building->setParentBuilt(true);
                } else {
                    $building->setParentBuilt(false);
                }
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
            case "B0004":
                $storage = new storageController("",$zoneItem->getZoneID());
                $storage->setLockBuilt(1);
                $storage->setLockStrength(20);
                $storage->setLockMax(20);
                $storage->uploadStorage();
                break;
            case "B0005":
                $zoneItem->setLockBuilt(1);
                $zoneItem->setLockStrength(20);
                $zoneItem->setLockMax(20);
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
        return $zoneItem;
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