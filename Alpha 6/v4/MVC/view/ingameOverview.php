<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class ingameOverview
{
    protected $itemBackpack;
    protected $itemGround;
    protected $itemChest;
    protected $storageDetails;
    protected $buildingList;
    protected $backpack;
    protected $zoneID;
    protected $coordX;
    protected $coordY;
    protected $depleted;
    protected $biomeType;
    protected $mapSize;
    protected $zoneBuildings;
    protected $zonePlayers;
    protected $avatarImage;
    protected $partyName;
    protected $partyPlayers;
    protected $partyRequests;
    protected $researchCurrent;
    protected $researchTotal;
    protected $researchLevel;
    protected $researchOptions;
    protected $currentBackpack;
    protected $backpackUp1;
    protected $backpackUp2;
    protected $recipeList;
    protected $consumeList;
    protected $fenceCurrent;
    protected $fenceMax;
    protected $storageLockCurrent;
    protected $storageLockMax;
    protected $actions;
    protected $shrineScores;
    protected $eventsList;


    function __construct($avatar,$zone,$map,$party,$type,$secondView)
    {
        $this->itemBackpack = itemView::getArrayView($avatar->getInventory());
        $this->itemGround = itemView::getArrayView($zone->getZoneItems());
        $storage = new storageController("", $avatar->getZoneID());
        $accessCheck = buildingItemController::lockChecker($avatar,$zone,$storage,true);
        if ($accessCheck === true) {
            $this->itemChest = itemView::getAllItemsView($avatar->getMapID(), "storage", $storage->getStorageID());
            $this->storageDetails = $storage->returnVars();
        } else {
            $this->itemChest = "Locked";
            $this->storageDetails = "Locked";
        }
        $accessFenceCheck = buildingItemController::lockChecker($avatar,$zone,"",false);
        if ($accessFenceCheck === true) {
            $this->storageLockCurrent = $storage->getLockStrength();
            $this->storageLockMax = $storage->getLockMax();
        } else {
            $this->storageLockCurrent = 0;
            $this->storageLockMax = 0;
        }
        $this->backpack = $avatar->getMaxInventorySlots();
        $this->zoneID = $zone->getZoneID();
        $this->coordX = $zone->getCoordinateX();
        $this->coordY = $zone->getCoordinateY();
        if ($zone->getFindingChances() > 0){
            $this->depleted = false;
        } else {
            $this->depleted = true;
        }
        $this->biomeType = $zone->getBiomeType();
        $this->mapSize = $map->getEdgeSize();
        $this->zoneBuildings = $zone->getBuildings();
        $this->zonePlayers = self::createZoneAvatars($zone,$avatar);
        $this->avatarImage = $avatar->getAvatarImage();
        $this->researchLevel = $avatar->getResearchStatsLevel();
        $this->researchCurrent = $avatar->getResearchStatsStamina();
        $this->researchTotal = buildingLevels::researchStaminaLevels($avatar->getResearchStatsLevel());
        $this->researchOptions = buildingItemController::getAvailableResearchOptions($avatar,"view");
        $this->recipeList = self::getAllRecipes($this->itemBackpack,$zone);
        $this->consumeList = self::getAllConsumable($this->itemBackpack);
        $this->fenceCurrent = $zone->getLockStrength();
        $this->fenceMax = $zone->getLockMax();
        $this->createBackpacks($avatar->getTempModLevel());
        $this->createActionsList($zone,$storage,$map);
        if ($secondView === 0){
            $this->eventsList = chatlogAllController::getAllLogs($avatar,$map,$party,$zone,"current");
        } else if ($secondView === 1){
            if ($accessFenceCheck === true) {
                $this->buildingList = buildingItemController::checkItems($avatar, $type);
            } else {
                $this->buildingList = "Locked";
            }

        } else if ($secondView === 2){
            $this->partyName = $party->getPartyName();
            $arrayObjects = avatarController::getAvatarsInArray($party->getMembers(),true);
            $this->partyPlayers = otherAvatarView::getAllPlayers($avatar,$party,"inParty",$arrayObjects);
            $this->getRequestView($party,$avatar,$arrayObjects);
        } else if ($secondView === 3){
            $this->shrineScores = shrineView::createAllShrineView($avatar,$party,$map);
        }
        $shrine = new shrineController(80);
        $this->getTest = $shrine->getShrineAlertMessage();
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function createIngameOverview($profile,$type,$secondView){
        $secondViewClean = intval(preg_replace(data::$cleanPatterns['num'],"",$secondView));
        $avatar = new avatarController($profile->getAvatar());
        $zone = new zoneController($avatar->getZoneID());
        $map = new mapController($avatar->getMapID());
        $party = new partyController($avatar->getPartyID());
        $view = new ingameOverview($avatar,$zone,$map,$party,$type,$secondViewClean);
        return $view->returnVars();
    }

    private static function createZoneAvatars($zone,$avatar){
        $avatarList = avatarController::getAvatarsInArray($zone->getAvatars(),true);
        $finalArray = [];
        $party = new partyController($avatar->getPartyID());
        foreach ($avatarList as $player){
            if ($player->getAvatarID() !== $avatar->getAvatarID()) {
                $temp = new otherAvatarView($player, $avatar,false,array(),$party);
                $finalArray[$player->getAvatarID()] = $temp->returnVars();
            }
        }
        return $finalArray;
    }

    public function getAllRecipes($backpack,$zone){
        $itemArray = [];
        foreach ($backpack as $item){
            array_push($itemArray,$item["itemTemplateID"]);
        }
        $result = recipe::findRecipe($itemArray,$zone->getBuildings(),false);
        return $result;
    }

    public function getAllConsumable($backpack){
        $itemArray = [];
        foreach ($backpack as $item){
            if ($item['usable']) {
                array_push($itemArray, $item);
            }
        }
        return $itemArray;
    }

    public function createBackpacks($current){
        $start = new equipmentView($current);
        $this->currentBackpack = $start->returnVars();
        $up1 = new equipmentView($start->getUpgrade1());
        $this->backpackUp1 = $up1->returnVars();
        $up2 = new equipmentView($start->getUpgrade2());
        $this->backpackUp2 = $up2->returnVars();
    }

    function getRequestView($party,$avatar,$membersArray){
        $requests = $party->getPendingRequests();
        $finalArray = [];
        foreach ($requests as $item){
            $other = new avatarController($item);
            $temp = new otherAvatarView($other,$avatar,true,$membersArray,$party);
            $finalArray[$other->getAvatarID()] = $temp->returnVars();
        }
        $this->partyRequests = $finalArray;
    }

    function createActionsList($zone,$storage,$map){
        $finalArray = [];
        if ($zone->getBiomeType() !== 100){
                if ($zone->getFindingChances() > 0){
                    //VAR 1 = SEARCH
                    array_push($finalArray,1);
                    //VAR 2 = EXPLODE
                    array_push($finalArray,2);
                } else {
                    //VAR 9 = CANT SEARCH
                    array_push($finalArray,9);
                    //VAR 10 = CANT EXPLODE
                    array_push($finalArray,10);
                }
        } else {
            //VAR 8 = WORSHIP
            array_push($finalArray,8);
        }
        if ($this->itemChest === "Locked"){
            if ($this->buildingList === "Locked"){
                //VAR 3 = DESTROY WALL
                array_push($finalArray,3);
            } else {
                //VAR 4 = DESTROY CHEST
                array_push($finalArray,4);
            }
        }else {
            if ($zone->getLockBuilt() > 0){
                if ($zone->getLockStrength() < $zone->getLockMax()){
                    //VAR 5 = REPAIR WALL
                    array_push($finalArray,5);
                } else {
                    //VAR 11 = CANT REPAIR WALL
                    array_push($finalArray,11);
                }
            }
            if ($storage->getLockBuilt() > 0){
                if ($storage->getLockStrength() < $storage->getLockMax()){
                    //VAR 6 = REPAIR CHEST
                    array_push($finalArray,6);
                } else {
                    //VAR 12 = CANT REPAIR WALL
                    array_push($finalArray,12);
                }
            }
        }
        if ($map->getGameType() == 5){
            //VAR 7 = ADD STAMINA
            array_push($finalArray,7);
        }
        $this->actions = $finalArray;
    }
}