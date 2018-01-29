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
                    $avatar->useStamina(1);
                    $avatar->addPlayStatistics("search", 1);
                    $findingchance = self::findingChances($zone->getBiomeType(), $avatar,$zone->getFindingChances());
                    $zone->reduceFindingChances();
                    if ($findingchance === 0) {
                        $avatar->increaseFindingChanceFail(1);
                        $avatar->updateAvatar();
                        $zone->updateZone();
                        chatlogPersonalController::searchZone($avatar->getAvatarID(),"nothing");
                        return array("Success" => true);
                    } else {
                        $itemID = self::addNewItem($zone->getBiomeType(), $zone->getMapID(), $zone->getZoneID());
                        if ($itemID != "ERROR") {
                            $avatar->resetFindingChanceFail();
                            $zone->updateZone();
                            $avatar->updateAvatar();
                            $item = new itemController($itemID);
                            chatlogPersonalController::searchZone($avatar->getAvatarID(),$item->getIdentity());
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
            $biome = new biomeTypeController($biomeID);
            return rand(0, ($biome->getFindingChanceMod() + $avatar->calculateFindingChanceMod()));
        }
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
                    if($avatar->getZoneID() === $item->getLocationID()) {
                        $item->setItemLocation("backpack");
                        $item->setLocationID($avatar->getAvatarID());
                        $item->updateItem();
                        $avatar->addInventoryItem($itemID);
                        $avatar->updateAvatar();
                        return array("SUCCESS" => true);
                    } else {
                        return array("ERROR" => 3);
                    }
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

    public static function useRecipe($recipeID,$avatarID)
    {
        $avatar = new avatarController($avatarID);
        $zoneInfo = itemController::getItemArray($avatar->getMapID(), "backpack", $avatar->getAvatarID());
        $recipe = new recipeController($recipeID);
        $zone = new zoneController($avatar->getZoneID());
        $tester = false;
        foreach ($zoneInfo as $item) {
            if ($item["itemTemplateID"] == $recipe->getRequiredItems()) {
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
            foreach ($recipe->getConsumedItems() as $requiredItem) {
                $itemExists = false;
                $avatarItems = itemController::getItemArray($avatar->getMapID(), "backpack", $avatar->getAvatarID());
                foreach ($avatarItems as $backpackItem) {
                    if ($backpackItem["itemTemplateID"] == $requiredItem) {
                        if ($itemExists === false) {
                            $itemExists = true;
                            $avatar->removeInventoryItem($backpackItem["itemID"]);
                        }
                    }
                }
                if ($itemExists === false) {
                    $item = self::missingItemDetails($recipe->getConsumedItems());
                    return array("ALERT" => "2", "DATA" => $item);
                }
            }
            //Avatar is refreshed to allow a second run at removing of the items (for real this time)
            $avatar = new avatarController($avatarID);
            $checker = self::checkImpact($recipe->getStatusImpact(), $avatar);
            if (array_key_exists("ERROR", $checker)) {
                return $checker;
            } else {
                //Loop is repeated to actually remove the items from the game this time
                foreach ($recipe->getConsumedItems() as $requiredItem) {
                    $itemExistsNew = false;
                    $avatarItems = itemController::getItemArray($avatar->getMapID(), "backpack", $avatar->getAvatarID());
                    foreach ($avatarItems as $backpackItem) {
                        if ($backpackItem["itemTemplateID"] == $requiredItem) {
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
                $response = achievementController::checkAchievement($recipeID);
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
                return array("ALERT" => 1, "DATA" => $recipe->getRecipeComment());
            }
        }
    }


    private static function checkImpact($statusImpact,$avatarModel){
        switch ($statusImpact){
            case 2:
                if ($avatarModel->getSingleStatus(5) === 1){
                    return array("ERROR"=>63);
                } else {
                    $avatarModel->removeSingleStatus(1);
                    $avatarModel->removeSingleStatus(2);
                    $avatarModel->changeStatusArray(5);
                    return array("SUCCESS"=>true);
                }
                break;
            case 3:
                if ($avatarModel->getSingleStatus(4) === 1){
                    return array("ERROR"=>66);
                } else {
                    $avatarModel->changeStatusArray(4);
                    return array("SUCCESS"=>true);
                }
                return array("SUCCESS"=>true);
                break;
            case 4:
                return array("SUCCESS"=>true);
                break;
            default:
                return array("SUCCESS"=>true);
                break;
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