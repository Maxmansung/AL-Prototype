<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/zoneController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/recipeController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/buildingItemController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogPersonalController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/data/buildingLevels.php");

class avatarOverviewController
{

    protected $recipes;
    protected $backpack;
    protected $maxBackpack;
    protected $tempBase;
    protected $tempMod;
    protected $modifierLevel;
    protected $tempItems;
    protected $researchLevel;
    protected $researchStamina;
    protected $researchCost;
    protected $profilePic;
    protected $upgradeLevel;
    protected $upgradeCost;


    function returnVars(){
        return get_object_vars($this);
    }

    function getBackpack(){
        return $this->backpack;
    }

    function setBackpack($var){
        $this->backpack = $var;
    }

    function getRecipes(){
        return $this->recipes;
    }

    function setRecipes($var){
        $this->recipes = $var;
    }

    private function __construct($avatar,$zone,$picture)
    {
        $this->profilePic = $picture;
        $this->tempBase = $avatar->getAvatarSurvivableTemp();
        $this->modifierLevel = $avatar->getTempModLevel();
        $this->researchLevel = $avatar->getResearchStatsLevel();
        $this->researchStamina = $avatar->getResearchStatsStamina();
        $this->backpack = $this->getBackpackItems($avatar->getInventory());
        $this->tempItems = avatarController::getItemBonuses($avatar->getInventory());
        $this->maxBackpack = $avatar->getMaxInventorySlots();
        $zoneProtected = $zone->getControllingParty();
        $lockValue = buildingController::getLockValue($zone->getZoneID());
        if ($zoneProtected != "empty") {
            if ($lockValue < 1 || $zoneProtected == $avatar->getPartyID()) {
                $this->zoneBuildings = $zone->getBuildings();
            } else {
                $this->zoneBuildings = array();
            }
        } else {
            $this->zoneBuildings = $zone->getBuildings();
        }
        $this->recipes = $this->createRecipeList($avatar->getInventory(),$this->zoneBuildings);
        $this->upgradeLevel = $this->modifierLevel;
        $this->upgradeCost = $this->upgradeItems();
        $this->researchCost = buildingLevels::researchStaminaLevels($this->researchLevel);
        $this->tempMod = buildingLevels::sleepingBagLevelBonus($this->modifierLevel);
    }

    public static function performResearch($avatarID){
        $avatar = new avatarController($avatarID);
        $checker = self::completeResearch($avatar,false);
        if (array_key_exists("ERROR",$checker)){
            return $checker;
        } else {
            $avatar = new avatarController($avatarID);
        }
        if ($avatar->getStamina() <= 0){
            return array("ERROR"=>0);
        } else{
            if ($avatar->getResearchStatsStamina() >= buildingLevels::researchStaminaLevels($avatar->getResearchStatsLevel())){
                $checker = self::completeResearch($avatar,true);
                if (array_key_exists("ERROR",$checker)){
                    return $checker;
                }
                $avatar->updateAvatar();
                return array("SUCCESS"=>true);
            } else {
                $avatar->adjustResearchStatsStamina(1);
                $avatar->useStamina(1);
                $avatar->addPlayStatistics("research",1);
                if ($avatar->getResearchStatsStamina() >= buildingLevels::researchStaminaLevels($avatar->getResearchStatsLevel())){
                    $checker = self::completeResearch($avatar,true);
                    if (array_key_exists("ERROR",$checker)){
                        return $checker;
                    } else {
                        $avatar->updateAvatar();
                        return $checker;
                    }
                }
                $avatar->updateAvatar();
                return array("SUCCESS"=>true);
            }
        }
    }

    public static function completeResearch($avatar,$type)
    {
        $avatar->adjustResearchStatsStamina(1);
        $avatar->adjustResearchStatsLevel(1);
        $avatar->setResearchStats(1, 0);
        $buildList = $avatar->getResearched();
        $optionsList = buildingController::getAllBuildings();
        $finalList = [];
        foreach ($optionsList as $option) {
            if (!in_array($option->getBuildingTemplateID(), $buildList)) {
                if($option->getBuildingsRequired() === "0") {
                    array_push($finalList, $option->getBuildingTemplateID());
                }
                else {
                    if (in_array($option->getBuildingsRequired(), $buildList)) {
                        array_push($finalList, $option->getBuildingTemplateID());
                    }
                }
            }
        }
        if (count($finalList)!= 0 ) {
            $buildingFound = rand(0, (count($finalList) - 1));
            if (in_array($finalList[$buildingFound], $avatar->getResearched())) {
                return array("ERROR" => "This research is already known");
            } else {
                if ($type == true) {
                    $avatar->addResearched($finalList[$buildingFound]);
                    $building = new buildingController("");
                    $building->createNewBuilding($finalList[$buildingFound],$avatar->getZoneID());
                    chatlogPersonalController::findNewResearch($avatar->getAvatarID(),$building->getName());
                    return array("ALERT"=>3,"DATA"=>array("researchName"=>$building->getName(),"researchIcon"=>$building->getIcon(),"researchDescription"=>$building->getDescription()));
                } else {
                    return array("SUCCESS"=>true);
                }
            }
        } else {
            return array("ERROR"=>40);
        }
    }

    public static function upgradeSleepingBag($avatarID){
        $avatar = new avatarController($avatarID);
        $sleepingBagItems = buildingLevels::sleepingBagUpgradeCost($avatar->getTempModLevel());
        $deleteArray = [];
        foreach ($sleepingBagItems as $requirement => $number) {
            $counter = 1;
            $allItemsExist = false;
            $itemList = itemController::getItemArray($avatar->getInventory());
            foreach ($itemList as $item) {
                if ($allItemsExist === false) {
                    if ($requirement == $item["itemTemplateID"]) {
                        array_push($deleteArray, $item["itemID"]);
                        $avatar->removeInventoryItem($item["itemID"]);
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


    //////////////////////////FUNCTIONS//////////////////

    //This process uses recipes to create new items within players bags

    public static function useRecipe($recipeID,$avatarID){
        $avatar = new avatarController($avatarID);
        $zoneInfo = itemController::getItemArray($avatar->getInventory());
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
                $avatarItems = itemController::getItemArray($avatar->getInventory());
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
                $avatarItems = itemController::getItemArray($avatar->getInventory());
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
                $newItem->createNewItemByID($createdItemName, $avatar->getMapID());
                $newItem->insertItem();
                $avatar->addInventoryItem($newItem->getItemID());
                array_push($itemDetails,$newItem->getIdentity());
            }
            $avatar->updateAvatar();
            return array("ALERT"=>"1","DATA"=>$itemDetails);
        }
    }



    ///////////////////////////VIEW///////////////////////

    public static function avatarViewCreate($profileID){
        $profile = new profileController($profileID);
        $avatar = new avatarController($profile->getAvatar());
        $zone = new zoneController($avatar->getZoneID());
        $overview =  new avatarOverviewController($avatar,$zone,$profile->getProfilePicture());
        return $overview;
    }


    //This returns the backpack items array for the avatar
    private function getBackpackItems($avatarInventory){
        return itemController::getItemArray($avatarInventory);
    }

    //This returns a list of recipes that can be made based on the items in the players backpack and the buildings around
    private function createRecipeList($avatarInventory,$zoneBuildings){
        $itemList = itemController::returnItemIDArray($avatarInventory);
        return recipeController::findRecipe($itemList,$zoneBuildings);
    }

    private function upgradeItems(){
        $upgradeArray = buildingLevels::sleepingBagUpgradeCost($this->upgradeLevel);
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