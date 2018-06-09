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
                    $name = "biome".$zone->getBiomeType();
                    $biome = new $name();
                    $findingchance = self::findingChances($biome, $avatar,$zone->getFindingChances(),false);
                    $zone->reduceFindingChances();
                    $map = new mapController($avatar->getMapID());
                    if ($findingchance === 0) {
                        $avatar->increaseFindingChanceFail(1);
                        $avatar->updateAvatar();
                        $zone->updateZone();
                        chatlogPersonalController::searchZone($avatar,"nothing",$map->getCurrentDay());
                        return array("Success" => true);
                    } else {
                        for ($x = 0; $x < $findingchance; $x++){
                            $id = $biome->findItem();
                            $zone->addItem($id);
                            $itemName = "item".$id;
                            $item = new $itemName();
                            chatlogPersonalController::searchZone($avatar,$item->getIdentity(),$map->getCurrentDay());
                        }
                        $avatar->resetFindingChanceFail();
                        $response = achievementController::checkAchievement(array("ACTION","SEARCH"));
                        if ($response !== false) {
                            $avatar->addAchievement($response);
                        }
                        $zone->updateZone();
                        $avatar->updateAvatar();
                        return array("Success" => true);
                    }
                }
            }
        }
    }

    //This function works out the finding chances
    static function findingChances($biome,$avatar,$chancesLeft,$test){
        if ($chancesLeft <= 1){
            return intval($chancesLeft);
        } else {
            if ($test === false) {
                $total = $biome->getFindingChanceMod() - $avatar->calculateFindingChanceMod()+4;
            } else {
                $total = $biome->getFindingChanceMod() - $avatar+4;
            }
            if ($total <= 0){
                return 0;
            } else {
                $num = rand(0, $total);
                if ($num < 2){
                    return 0;
                } elseif ($num <8){
                    return 1;
                } else {
                    return 2;
                }
            }
        }
    }

    //This function is used to both drop and pick up items
    public static function dropItem($tempitem, $avatarID,$location){
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        if ($zone->getProtectedType() !== "none") {
            return array("ERROR"=>59);
        } else {
            $itemID = intval($tempitem);
            if ($location === "ground") {
                if (in_array($itemID,$zone->getZoneItems())) {
                    if (count($avatar->getInventory()) < $avatar->getMaxInventorySlots()) {
                        $zone->removeItem($itemID);
                        $avatar->addInventoryItem($itemID);
                        $avatar->updateAvatar();
                        $zone->updateZone();
                        return array("SUCCESS" => true);
                    } else {
                        return array("ERROR" => 6);
                    }
                } else {
                    return array("ERROR" => "The item ".$tempitem);
                }
            } elseif ($location === "backpack") {
                if (in_array($itemID,$avatar->getInventory())) {
                    $avatar->removeInventoryItem($itemID);
                    $avatar->updateAvatar();
                    $zone->addItem($itemID);
                    $zone->updateZone();
                    return array("SUCCESS" => true);
                } else {
                    return array("ERROR" => 3);
                }
            } else {
                return array("ERROR"=>"Somehow the wrong response has been given");
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
                            $item = self::addNewItem($zone);
                            if ($item != "ERROR") {
                                $zone->addItem($item);
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
                foreach ($avatar->getInventory() as $item){
                    if ($shrine->getWorshipCostValue() === $item){
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
                foreach ($avatar->getInventory as $item){
                    if ($shrine->getWorshipCostValue() === $item){
                        if ($checker === "ERROR"){
                            $checker = "SUCCESS";
                            $avatar->removeInventoryItem($item);
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
        $zone = new zoneController($avatar->getZoneID());
        $name = "recipe".intval($recipeID);
        $recipe = new $name();
        $tester = false;
        foreach ($avatar->getInventory() as $item) {
            if ($item == $recipe->getRequiredItems()) {
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
                foreach ($tempAvatar->getInventory() as $backpackItem) {
                    if ($backpackItem == $requiredItem) {
                        if ($itemExists === false) {
                            $itemExists = true;
                            $tempAvatar->removeInventoryItem($backpackItem);
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
                foreach ($avatar->getInventory() as $backpackItem) {
                    if ($backpackItem == $requiredItem) {
                        if ($itemExistsNew === false) {
                            $itemExistsNew = true;
                            $avatar->removeInventoryItem($backpackItem);
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
                if ($createdItem === "OTHER") {
                    $createdItemName = $recipe->differentResult($recipe->getRecipeID());
                    if (array_key_exists("STAMINA", $createdItemName)) {
                        $avatar->useStamina($createdItemName["STAMINA"] * -1);
                        $avatar->updateAvatar();
                    } else if (array_key_exists("SEARCH", $createdItemName)) {
                        $chances = $zone->getFindingChances();
                        $zone->setFindingChances($chances + $createdItemName["SEARCH"]);
                        $zone->updateZone();
                    } else if (array_key_exists("ITEM", $createdItemName)) {
                        $avatar->addInventoryItem($createdItemName["ITEM"]);
                        $comment = $recipe->getRecipeComment();
                        $name = "item".$createdItemName["ITEM"];
                        $newItem = new $name();
                        $comment .= $newItem->getIdentity();
                        $recipe->setRecipeComment($comment);
                    }
                } else {
                    $avatar->addInventoryItem($createdItem);
                }
            }
            $avatar->updateAvatar();
            return array("ALERT" => 9, "DATA" => $recipe->getRecipeComment());
        }
    }

    public static function consumeItem($itemID,$avatarID){
        $cleanItemID = intval(preg_replace(data::$cleanPatterns['num'],"",$itemID));
        $avatar = new avatarController($avatarID);
        if (in_array($cleanItemID,$avatar->getInventory()) === false){
            return array("ERROR"=>"This item doesnt exist in your baeg: ".$cleanItemID);
        } else {
            $name = "item".$cleanItemID;
            $item = new $name();
            $status = statusesController::checkConsumable($avatar->getStatusArray(), $item->getStatusImpact());
            if ($status !== true) {
                return array("ALERT" => 11, "DATA" => $status);
            } else {
                $avatar->removeInventoryItem($item->getItemTemplateID());
                $responseController = responseController::getStatusChangeType($item->getStatusImpact());
                $newStatuses = $responseController->statusChange($avatar->getStatusArray());
                $avatar->setStatusArray($newStatuses);
                $avatar->useStamina(($item->getMaxCharges() * -1));
                $response = achievementController::checkAchievement(array("RECIPE", $item->getItemTemplateID()));
                if ($response !== false) {
                    $avatar->addAchievement($response);
                }
                $avatar->updateAvatar();
                return array("ALERT" => 9, "DATA" => $responseController->getSucceedResponse());
            }
        }
    }

    private static function missingItemDetails($itemList){
        $itemsArray = [];
        foreach ($itemList as $itemID) {
            $name = "item".$itemID;
            $item = new $name();
            array_push($itemsArray,$item->returnVars());
        }
        return $itemsArray;
    }
}