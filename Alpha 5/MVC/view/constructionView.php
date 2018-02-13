<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class constructionView
{
    protected $buildings;
    protected $researchLevel;
    protected $researchCost;
    protected $researchStamina;
    protected $upgradeCostSleep;
    protected $upgradeCostBag;
    protected $zoneItems;
    protected $storageItems;
    protected $maxStorage;
    protected $backpackItems;
    protected $backpackSize;
    protected $firepitDetails;
    protected $storageDetails;
    protected $recipes;
    protected $usingItems;
    protected $mapType;
    protected $researchTypes;
    protected $lockDetails;

    function __construct($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $this->getAccess($avatar->getZoneID(),$avatar->getPartyID(),$avatar->getAvatarID());
        $this->modifierLevel = $avatar->getTempModLevel();
        $this->researchLevel = $avatar->getResearchStatsLevel();
        $this->researchStamina = $avatar->getResearchStatsStamina();
        $this->researchCost = buildingLevels::researchStaminaLevels($this->researchLevel);
        $this->upgradeCostSleep = $this->upgradeItems("sleepingBag",$avatar->getTempModLevel());
        $this->upgradeCostBag = $this->upgradeItems("backpack",$avatar->getMaxInventorySlots());
        $this->zoneItems = itemController::getItemArray($avatar->getMapID(),"ground",$avatar->getZoneID());
        $this->backpackItems = itemController::getItemArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
        $this->backpackSize= $avatar->getMaxInventorySlots();
        $this->lockDetails = $this->zoneLocks($avatar->getZoneID(),$avatar->getPartyID());
        $this->recipes = $this->createRecipeList($avatar);
        $map = new mapController($avatar->getMapID());
        $this->mapType = $map->getGameType();
        $this->researchTypes = buildingItemController::getAvailableResearchOptions($avatarID,"view");
        $this->usingItems = $this->getUseableItems();
    }

    function returnVars(){
        return get_object_vars($this);
    }

    private function zoneLocks($zoneID,$partyID)
    {
        $locks = [];
        $storageLockID = buildingController::getConstructedBuildingID("StorageLock", $zoneID);
        if (array_key_exists("ERROR", $storageLockID) !== true) {
            $storageLock = new buildingController($storageLockID);
            if ($storageLock->getStaminaSpent() === $storageLock->getStaminaRequired()) {
                $lock = new lockController($storageLock,$partyID);
                $locks["chest"] = $lock->returnVars();
            }
        }
        $zoneLockID = buildingController::getConstructedBuildingID("GateLock", $zoneID);
        if (array_key_exists("ERROR", $zoneLockID) !== true) {
            $zoneLock = new buildingController($zoneLockID);
            if ($zoneLock->getStaminaSpent() === $zoneLock->getStaminaRequired()) {
                $lock = new lockController($zoneLock,$partyID);
                $locks["gate"] = $lock->returnVars();
            }
        }
        return $locks;
    }

    private function getAccess($zoneID, $partyID, $avatarID){
        $zone = new zoneController($zoneID);
        $storageTest = true;
        $buildingTest = true;
        $firepitTest = true;
        if ($zone->getControllingParty() !== null && $zone->getControllingParty() !== $partyID) {
            $storageLock = buildingController::getConstructedBuildingID("StorageLock", $zoneID);
            if (array_key_exists("ERROR",$storageLock) !== true) {
                if ($storageLock->getStaminaSpent() === $storageLock->getStaminaRequired()) {
                    $storageTest = false;
                }
            }
            $zoneLock = buildingController::getConstructedBuildingID("GateLock", $zoneID);
            if (array_key_exists("ERROR",$zoneLock) !== true ) {
                if ($zoneLock->getStaminaSpent() === $zoneLock->getStaminaRequired()) {
                    $firepitTest = false;
                    $buildingTest = false;
                    $storageTest = false;
                }
            }
        }else {
        }
        if ($storageTest === true){
            $this->returnZoneStorage($zoneID);
            $this->storageItems = $this->getStorageItems($zoneID);
        } else {
            $this->storageDetails = array("ERROR" => "Lock");
            $this->storageItems = array("ERROR" => "Lock");
        }
        if ($buildingTest === true){
            $this->buildings = buildingItemController::checkItems($avatarID);
        } else {
            $this->buildings = array("ERROR" => "Lock");
        }
        if ($firepitTest === true){
            $this->returnFirepitData($zoneID);
        } else {
            $this->firepitDetails = array("ERROR" => "Lock");
        }
    }

    private function upgradeItems($type,$level){
        $upgradeArray = [];
        if ($type === "sleepingBag") {
            $upgradeArray = buildingLevels::sleepingBagUpgradeCost($level);
        } else if ($type === "backpack"){
            $upgradeArray = buildingLevels::backpackUpgradeCost($level);
        }
        $itemsArray = [];
        foreach ($upgradeArray as $item => $count) {
            $itemObject = new itemController("");
            $itemObject->createBlankItem($item);
            for ($x = 0; $x < $count; $x++) {
                $itemsArray[$itemObject->getIdentity() . $x] = $itemObject->returnVars();
            }
        }
        return $itemsArray;
    }

    private function getStorageItems($zoneID){
        $zone = new zoneController($zoneID);
        $storage = new storageController("",$zoneID);
        if ($storage->getStorageID() == "") {
            $storageItems = array("ERROR" => 7);
        } else {
            $storageItems = itemController::getItemArray($zone->getMapID(),"storage",$storage->getStorageID());
            $this->maxStorage = $storage->getMaximumCapacity();
        }
        return $storageItems;
    }

    private function returnFirepitData($zoneID)
    {
        $firepitBuilding = buildingController::getConstructedBuildingID("Firepit",$zoneID);
        if (array_key_exists("ERROR", $firepitBuilding)) {
            $this->firepitDetails = array("ERROR"=>7);
        } else {
            if ($firepitBuilding->getStaminaRequired() === $firepitBuilding->getStaminaSpent()) {
                $firepitController = new firepitController($firepitBuilding);
                $this->firepitDetails =  $firepitController->returnVars();
            } else {
                $this->firepitDetails = array("ERROR"=>7);
            }
        }
    }



    public function returnZoneStorage($zoneID)
    {
        $storageBuilding = buildingController::getConstructedBuildingID("Storage",$zoneID);
        if (array_key_exists("ERROR", $storageBuilding)) {
            $this->storageDetails = array("ERROR"=>7);
        } else {
            $storageComplete = new storageController($storageBuilding,$zoneID);
            if ($storageComplete->getZoneID() ===$zoneID) {
                $this->storageDetails =  $storageComplete->storageView();
            } else {
                $this->storageDetails = array("ERROR"=>7);
            }
        }
    }


    public function createRecipeList($avatar){
        $zone = new zoneController($avatar->getZoneID());
        $itemList = itemController::returnItemIDArray($avatar->getMapID(),"backpack",$avatar->getAvatarID());
        return recipeView::getRecipeView($itemList,$zone->getBuildings());
    }

    private function getUseableItems(){
        $itemList = [];
        foreach ($this->backpackItems as $item){
            $item = new itemController($item["itemID"]);
            if ($item->getStatusImpact() !== 1){
                $tempArray = array("image"=>$item->getIcon(),"description"=>"Use ".$item->getIdentity(),"templateID"=>$item->getItemTemplateID());
                $itemList[$item->getIdentity()] = $tempArray;
            }
        }
        return $itemList;
    }
}