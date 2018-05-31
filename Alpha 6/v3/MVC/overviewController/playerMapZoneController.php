<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class playerMapZoneController
{

    //This function is used to move the avatar in a direction around the map
    public static function moveAvatar($avatarID,$dir){
        $avatar = new avatarController($avatarID);
        if ($avatar->getStamina() <= 0){
            return array("ERROR" => 0);
        } else {
            $dirClean = preg_replace(data::$cleanPatterns['text'],"",$dir);
            $map = new mapController($avatar->getMapID());
            $avatar->useStamina(1);
            $currentZone = new zoneController($avatar->getZoneID());
            $newZone = new zoneController($avatar->getZoneID());
            $newZone = $newZone->nextMap($dirClean);
            //This small section prevents players from entering zones not claimed by their party
            if ($newZone->getControllingParty() !== null) {
                if ($newZone->getControllingParty() !== $avatar->getPartyID()) {
                    //return array("ERROR" => 1);
                }
            }
            if ($newZone->getMapID() != $avatar->getMapID()) {
                return array("ERROR" => 2);
            }
            chatlogMovementController::leaveCurrentZone($avatar,$dirClean,$map->getCurrentDay());
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
            if ($newZone->getFindingChances() > 0){
                $find = 1;
            } else {
                $find = 0;
            }
            if ($currentZone->getFindingChances() > 0){
                $find2 = 1;
            } else {
                $find2 = 0;
            }
            $party->addOverallZoneExploration($newZone->getName(),$newZone->getBiomeType(),$find);
            $party->addOverallZoneExploration($currentZone->getName(),$currentZone->getBiomeType(),$find2);
            $party->uploadParty();
            partyController::removeAllInvites($avatarID,$map->getCurrentDay());
            chatlogMovementController::enterNewZone($avatar,$dirClean,$map->getCurrentDay());
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
                    $avatar->useStamina(1);
                    $avatar->addPlayStatistics("search", 1);
                    $findingchance = self::findingChances($zone->getBiomeType(), $avatar,$zone->getFindingChances());
                    $zone->reduceFindingChances();
                    $map = new mapController($avatar->getMapID());
                    if ($findingchance === 0) {
                        $avatar->increaseFindingChanceFail(1);
                        $avatar->updateAvatar();
                        $zone->updateZone();
                        chatlogPersonalController::searchZone($avatar,"nothing",$map->getCurrentDay());
                        return array("Success" => true);
                    } else {
                        $item = self::addNewItem($zone->getBiomeType(), $zone->getMapID(), $zone->getZoneID());
                        if ($item != "ERROR") {
                            $avatar->resetFindingChanceFail();
                            $zone->updateZone();
                            $response = achievementController::checkAchievement(array("ACTION","SEARCH"));
                            if ($response !== false) {
                                $avatar->addAchievement($response);
                            }
                            $avatar->updateAvatar();
                            chatlogPersonalController::searchZone($avatar,$item->getIdentity(),$map->getCurrentDay());
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
    private static function findingChances($biomeID,$avatar,$chancesLeft){
        if ($chancesLeft <= 1){
            return intval($chancesLeft);
        } else {
            $class = "biome".$biomeID;
            $biome = new $class();
            $total = $biome->getFindingChanceMod() - $avatar->calculateFindingChanceMod();
            if ($total <= 0){
                return 0;
            } else {
                return rand(0, $total);
            }
        }
    }

    //This function is used to convert the template into an item when picking up
    public static function pickItem($tempItemID,$avatarID){
        $tempClean = preg_replace(data::$cleanPatterns['text'],"",$tempItemID);
        $avatar = new avatarController($avatarID);
        $id = itemModel::getItemIDsFromLocationGround($avatar->getMapID(),"ground",$avatar->getZoneID(),$tempClean);
        return self::dropItem($id,$avatarID);
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
                }else {
                    return array("ERROR" => 6);
                }
            } elseif ($item->getLocationID() === $avatar->getAvatarID()) {
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
                        $chancesLeft = $chances-$x;
                        $findingchance = self::findingChances($zone->getBiomeType(), $avatar,$chancesLeft);
                        if ($findingchance != 0) {
                            $item = self::addNewItem($zone->getBiomeType(), $zone->getMapID(), $zone->getZoneID());
                            if ($item != "ERROR") {
                                $found += 1;
                            }
                        }
                    }
                    $zone->setFindingChances(0);
                    $avatar->useStamina(5);
                    $avatar->addPlayStatistics("break", 5);
                    $response = achievementController::checkAchievement(array("ACTION","DESTROY"));
                    if ($response !== false) {
                        $avatar->addAchievement($response);
                    }
                    $avatar->updateAvatar();
                    $zone->updateZone();
                    $map = new mapController($avatar->getMapID());
                    chatlogMovementController::destroyBiome($avatar,$map->getCurrentDay());
                    return array("ALERT" => 8, "DATA" => array("foundItems" => $found, "biome" => $zone->getBiomeType()));
                }
            }
        }
    }

    private static function addNewItem($biomeType,$mapID,$zoneID){
        $item = new itemController("");
        $class = "biome".$biomeType;
        $biome = new $class();
        $item->createNewItem($biome->getValue(), $mapID,$zoneID,"ground");
        if ($item->getItemID() == ""){
            return "ERROR";
        }
        $item->insertItem();
        return $item;
    }

    public static function worshipShrine($shrineID, $avatarID){
        $avatar = new avatarController($avatarID);
        $shrine = new shrineController($shrineID);
        if ($shrine->getZoneID() !== $avatar->getZoneID()){
            return array("ERROR"=>"You are not in the correct zone to perform this action");
        } else{
            $party = new partyController($avatar->getPartyID());
            if (count($party->getMembers()) < $shrine->getMinParty() || count($party->getMembers())>$shrine->getMaxParty()){
                return array("ERROR"=>67);
            } else {
                $checker = self::worshipChecker($avatar, $shrine);
                if ($checker === false) {
                    return array("ERROR" => 60);
                } else {
                    $checker = self::worshipCoster($avatar, $shrine);
                    if ($checker === "ERROR") {
                        return array("ERROR" => "Something has gone wrong with the 'Worship Coster' function");
                    } else {
                        $map = new mapController($avatar->getMapID());
                        shrineActionsController::createNewWorship($avatar,$party,$map,$shrine);
                        return array("ALERT" => 9,"DATA"=>$shrine->getShrineName()." is pleased with your sacrifice. Keep working at it to become this gods chosen champion for the night");
                    }
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

    public static function useRecipe($recipeID,$avatarID)
    {
        $avatar = new avatarController($avatarID);
        $tempAvatar = $avatar;
        $avatarItems = itemController::getItemsAsObjects($avatar->getMapID(), "backpack", $avatar->getAvatarID());
        $recipe = new recipeController($recipeID);
        $zone = new zoneController($avatar->getZoneID());
        $tester = false;
        foreach ($avatarItems as $item) {
            if ($item->getItemTemplateID() == $recipe->getRequiredItems()) {
                $tester = true;
            }
        }
        foreach ($zone->getBuildings() as $building) {
            if ($building == $recipe->getRequiredBuildings()) {
                $tester = true;
            }
        }
        if ($tester === false) {
            return array("ERROR" => 12);
        } else {
            $tempItems = $avatarItems;
            foreach ($recipe->getConsumedItems() as $requiredItem) {
                $itemExists = false;
                foreach ($tempItems as $backpackItem) {
                    if ($backpackItem->getItemTemplateID() == $requiredItem) {
                        if ($itemExists === false) {
                            $itemExists = true;
                            $tempAvatar->removeInventoryItem($backpackItem->getItemID());
                            unset($tempItems[$backpackItem->getItemID()]);
                        }
                    }
                }
                if ($itemExists === false) {
                    $item = self::missingItemDetails($recipe->getConsumedItems());
                    return array("ALERT" => "10", "DATA" => $item);
                }
            }
            //Loop is repeated to actually remove the items from the game this time
            foreach ($recipe->getConsumedItems() as $requiredItem) {
                $itemExistsNew = false;
                foreach ($avatarItems as $backpackItem) {
                    if ($backpackItem->getItemTemplateID() == $requiredItem) {
                        if ($itemExistsNew === false) {
                            $itemExistsNew = true;
                            $avatar->removeInventoryItem($backpackItem->getItemID());
                            $backpackItem->delete();
                            unset($avatarItems[$backpackItem->getItemID()]);
                        }
                    }
                }
            }
            //This then creates the new items
            $response = achievementController::checkAchievement(array("RECIPE", $recipeID));
            if ($response !== false) {
                $avatar->addAchievement($response);
            }
            foreach ($recipe->getGeneratedItems() as $createdItem) {
                if ($createdItem === "I000X") {
                    $createdItemName = recipeController::differentResult($recipe->getRecipeID());
                    if (array_key_exists("STAMINA", $createdItemName)) {
                        $avatar->useStamina($createdItemName["STAMINA"] * -1);
                        $avatar->updateAvatar();
                    } else if (array_key_exists("SEARCH", $createdItemName)) {
                        $chances = $zone->getFindingChances();
                        $zone->setFindingChances($chances + $createdItemName["SEARCH"]);
                        $zone->updateZone();
                    } else if (array_key_exists("ITEM", $createdItemName)) {
                        $newItem = new itemController("");
                        $newItem->createNewItemByID($createdItemName["ITEM"], $avatar->getMapID(), $avatar->getAvatarID(), "backpack");
                        $newItem->insertItem();
                        $avatar->addInventoryItem($newItem->getItemID());
                        $comment = $recipe->getRecipeComment();
                        $comment .= $newItem->getIdentity();
                        $recipe->setRecipeComment($comment);
                    }
                } else {
                    $createdItemName = $createdItem;
                    $newItem = new itemController("");
                    $newItem->createNewItemByID($createdItemName, $avatar->getMapID(), $avatar->getAvatarID(), "backpack");
                    $newItem->insertItem();
                    $avatar->addInventoryItem($newItem->getItemID());
                }
            }
            $avatar->updateAvatar();
            return array("ALERT" => 9, "DATA" => $recipe->getRecipeComment());
        }
    }

    public static function consumeItem($itemID,$avatarID){
        $cleanItemID = intval(preg_replace(data::$cleanPatterns['num'],"",$itemID));
        $avatar = new avatarController($avatarID);
        $backPack = itemController::getItemsAsObjects($avatar->getMapID(),"backpack",$avatar->getAvatarID());
        $checker = false;
        foreach ($backPack as $newItem){
            if($newItem->getItemID() === $cleanItemID){
                $checker = $newItem->getItemID();
            }
        }
        if ($checker === false){
            return array("ERROR"=>"This item doesnt exist in your baeg: ".$cleanItemID);
        } else {
            $item = $backPack[$checker];
            if ($item->getItemTemplateID() === null){
                return array("ERROR"=>"Somehow the item is no longer around");
            } else {
                $status = statusesController::checkConsumable($avatar->getStatusArray(), $item->getStatusImpact());
                if ($status !== true) {
                    return array("ALERT" => 11, "DATA" => $status);
                } else {
                    $avatar->removeInventoryItem($item->getItemID());
                    $responseController = responseController::getStatusChangeType($item->getStatusImpact());
                    $newStatuses = $responseController->statusChange($avatar->getStatusArray());
                    $avatar->setStatusArray($newStatuses);
                    $avatar->useStamina(($item->getMaxCharges()*-1));
                    $response = achievementController::checkAchievement(array("RECIPE",$item->getItemTemplateID()));
                    if ($response !== false) {
                        $avatar->addAchievement($response);
                    }
                    $item->delete();
                    $avatar->updateAvatar();
                    return array("ALERT" => 9, "DATA" => $responseController->getSucceedResponse());
                }
            }
        }
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