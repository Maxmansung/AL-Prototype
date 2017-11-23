<?php
if (isset($_POST["type"])) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/avatarOverviewController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/HUDController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/deathScreenController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/playerMapZoneController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/partyZonePlayerController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/mapPlayerController.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/newMapJoinController.php");
    $type = intval(preg_replace('#[^0-9]#i', '', $_POST['type']));
    $data = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['data']);
    $control = "x";
    switch ($type) {
        case 0:
            //Used to show the avatar screen
            $response = array("SUCCESS" => true);
            $control = 0;
            //No actions performed
            break;
        case 1:
            //Used to perform a recipe
            $response = avatarOverviewController::useRecipe($data, $profile->getAvatar());
            $control = 0;
            //Returns ERROR or ALERT or SUCCESS
            break;
        case 2:
            //Used to upgrade sleeping bag
            $response = avatarOverviewController::upgradeSleepingBag($profile->getAvatar());
            $control = 0;
            //Returns ERROR or SUCCESS
            break;
        case 3:
            //Used to perform research
            $response = avatarOverviewController::performResearch($profile->getAvatar());
            $control = 0;
            //Returns ERROR or ALERT or SUCCESS
            break;
        case 4:
            //Used for the buildings screen
            $response = array("SUCCESS" => true);
            $control = 1;
            //No actions performed
            break;
        case 5:
            //Used for building in adding stamina to buildings
            $response = buildingItemController::buildBuilding($data,$profile->getAvatar(),1);
            $control = 1;
            //Returns ERROR or SUCCESS
            break;
        case 6:
            //Used to change a players ready status
            $response = HUDController::changeReady($profile->getAvatar());
            //Returns ERROR or ALERT
            break;
        case 7:
            //Used to confirm a players death
            $response = $profile->confirmdeath();
            $control = $response;
            //Returns ERROR
            break;
        case 8:
            //Used to check if the timer has expired
            $HUD = HUDController::getHUDStats($profile->getAvatar());
            $response = $HUD->tempCheckTimerEnd();
            $control = $response;
            //Returns ERROR
            break;
        case 9:
            //Used to show the death screen
            $response = array("SUCCESS"=>true);
            $control = 2;
            //No actions performed
            break;
        case 10:
            //Used to show the firepit screen
            $response = array("SUCCESS"=>true);
            $control = 3;
            //No actions performed
            break;
        case 11:
            //Used when an item is dropped into the firepit
            $response = buildingItemController::firepitDrop($data, $profile->getAvatar());
            $control = 3;
            //Returns ERROR or SUCCESS
            break;
        case 12:
            //Used to show the Actions screen
            $response = array("SUCCESS"=>true);
            $control = 4;
            //No actions performed
            break;
        case 13:
            //Used to show the Overview screen
            $response = array("SUCCESS"=>true);
            $control = 5;
            //No actions performed
            break;
        case 14:
            //Used when a player reinforces or breaks the gate lock
            $response = buildingItemController::impactLock($profile->getAvatar(),$data,"GateLock");
            $control = 5;
            //Returns ERROR or SUCCESS
            break;
        case 15:
            //Used to show the storage screen
            $response = array("SUCCESS"=>true);
            $control = 6;
            //No actions performed
            break;
        case 16:
            //Used to drop an item into the storage
            $response = buildingItemController::storageItemTransfer($data,$profile->getAvatar());
            $control = 6;
            //Returns ERROR or SUCCESS
            break;
        case 17:
            //Used to upgrade the storage building
            $response = buildingItemController::upgradeStorage($profile->getAvatar());
            $control = 6;
            //Returns ERROR or SUCCESS
            break;
        case 18:
            //Used when a player reinforces or breaks the storage lock
            $response = buildingItemController::impactLock($profile->getAvatar(),$data,"StorageLock");
            $control = 6;
            //Returns ERROR or SUCCESS
            break;
        case 19:
            //Used to show the map screen
            $response = array("SUCCESS"=>true);
            $control = 7;
            //No actions performed
            break;
        case 20:
            //Used when a player
            $response = playerMapZoneController::moveAvatar($profile->getAvatar(),$data);
            $control = 7;
            //Returns ERROR or SUCCESS
            break;
        case 21:
            //Used when a player
            $response = playerMapZoneController::dropItem($data, $profile->getAvatar());
            $control = 9;
            //Returns ERROR or SUCCESS
            break;
        case 22:
            //Used when a player
            $response = playerMapZoneController::searchZone($profile->getAvatar());
            $control = 9;
            //Returns ERROR or SUCCESS
            break;
        case 23:
            //Used when a player
            $response = playerMapZoneController::destroyBiome($profile->getAvatar());
            $control = 9;
            //Returns ERROR or ALERT
            break;
        case 24:
            //Used to show the a single zones information
            $response = array("SUCCESS"=>true);
            $control = 8;
            //No actions performed
            break;
        case 25:
            //Used to show the a single zones information
            $response = array("SUCCESS"=>true);
            $control = 10;
            //No actions performed
            break;
        case 26:
            //Used when a player wants to leave a party
            $response = partyZonePlayerController::leaveParty($profile->getAvatar());
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 27:
            //Used when a player wants to kick a player from the party
            $response = partyZonePlayerController::kickPlayer($profile->getAvatar(),$data);
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 28:
            //Used when a player wants to accept a player to the party
            $response = partyZonePlayerController::votingOnPlayer($profile->getAvatar(),$data,"accept");
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 29:
            //Used when a player wants to reject a player from the party
            $response = partyZonePlayerController::votingOnPlayer($profile->getAvatar(),$data,"reject");
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 30:
            //Used when a player wants to join another players party
            $response = partyZonePlayerController::joinParty($profile->getAvatar(),$data);
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 31:
            //Used when a player wants to change their groups name
            $response = partyZonePlayerController::changeGroupName($profile->getAvatar(),$data);
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 32:
            //Used when a player wants to cancel a request to join a party
            $response = partyZonePlayerController::cancelJoin($profile->getAvatar(),$data);
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 33:
            //Used when a player wants to check if they can teach another player something
            $response = partyZonePlayerController::getResearchTeaching($profile->getAvatar(),$data);
            $control = 11;
            //Returns ERROR or ALERT
            break;
        case 34:
            //Used when a player wants to teach another player something
            $player = preg_replace('#[^A-Za-z0-9_\s]#i', '', $_POST['other']);
            $response = partyZonePlayerController::teachPlayerResearch($player,$profile->getAvatar(),$data);
            $control = 10;
            //Returns ERROR or ALERT
            break;
        case 35:
            //Used to show the players profile page
            $response = array("SUCCESS"=>true);
            $control = 12;
            //No actions performed
            break;
        case 36:
            //Used to show players profile edit page
            $response = array("SUCCESS"=>true);
            $data = $profile->getProfileID();
            $control = 12;
            //No actions performed
            break;
        case 37:
            //Used to log the player out of the game
            $response = $profile->destroysession();
            $control = $response;
            //Returns ERROR only
            break;
        case 38:
            //Used to show the players that are searched for
            $reponse = array("SUCCESS"=>true);
            $control = 13;
            //No actions performed
            break;
        case 39:
            //Used to show the players that are searched for
            $reponse = array("SUCCESS"=>true);
            $control = 14;
            //No actions performed
            break;
        case 40:
            //This is used to join a player to a game
            $response = newMapJoinController::addAvatar($data,$profile->getProfileID());
            $control = $response;
            //Returns ERROR or ALERT
            break;
        case 41:
            //This is used to join a player to a game
            $response = newMapJoinController::deleteGame($data,$profile->getAccountType());
            $control = $response;
            //Returns ERROR
            break;
        default:
            $response = array("ERROR"=>"Bad AJAX request sent - ID: ".$type);
            break;

        //200+ functions are used only for testing and can be removed from the main game

        case 201:
            //Used for the insta-Death button
            $response = HUDController::playerDeathButton($profile->getAvatar());
            $control = $response;
            //Returns ERROR
            break;
        case 202:
            //Used for stamina refreshing
            $response = HUDController::refreshStamina($profile->getAvatar());
            $control = $response;
            //Returns ERROR
            break;
        case 203:
            //Used for ending the day
            $response = HUDController::adminDayEnding($profile->getProfileID());
            $control = $response;
            //Returns ERROR
            break;
        default:
            $response = array("ERROR" => "No known AJAX type sent");
            $control = 99999;
    }

    //THIS THEN CHECKS THE RESPONSE ARRAY TO UNCOVER WHAT NEEDS TO BE RETURNED

    //Errors are returned and processed here
    if (array_key_exists("ERROR", $response)) {
        echo json_encode($response);
    }
    //Alerts can also be returned to be processed differently from errors
    elseif (array_key_exists("ALERT", $response)) {
        echo json_encode($response);
    }
    //Success then continues onto the view array
    else {

        //THIS THEN CHOOSES HOW TO RESPOND TO THE PAGE, THESE ARRAYS CAN BE QUITE LARGE AND SO ARE ONLY USED IN SUCCESSFUL EVENTS

        $viewHUD = true;

        switch ($control) {
            case 0:
                //This returns the avatar view item
                $view = avatarOverviewController::avatarViewCreate($profile->getProfileID());
                $view = $view->returnVars();
                break;
            case 1:
                //This returns the buildings view
                $view = buildingItemController::checkItems($profile->getAvatar());
                break;
            case 2:
                //This returns the death screen view
                $view = new deathScreenController($profile->getProfileID());
                $view = $view->returnVars();
                $viewHUD = false;
                break;
            case 3:
                //This returns the firepit screen view
                $view = buildingItemController::returnFirepitData($profile->getAvatar());
                break;
            case 4:
                //This returns the diary screen view
                $view = chatlogAllController::getAllLogs($profile->getAvatar(),$data);
                break;
            case 5:
                //This returns the overview screen
                $view = playerMapZoneController::getPlayerMapZoneController($profile->getAvatar());
                break;
            case 6:
                //This returns the storage screen
                $view = buildingItemController::returnZoneStorage($profile->getAvatar());
                break;
            case 7:
                //This returns the map screen
                $mapZone = playerMapZoneController::getCurrentZoneInfo($profile->getAvatar());
                $view = $mapZone->arrayView($profile->getAvatar());
                break;
            case 8:
                //This returns the information only about a single zone
                $view = playerMapZoneController::getZoneInfo($data,$profile->getAvatar());
                $view = $view->returnVars();
                break;
            case 9:
                //This returns information about the players items only
                $mapZone = playerMapZoneController::getCurrentZoneInfo($profile->getAvatar());
                $view = $mapZone->allItemsView($profile->getAvatar());
                $view["findingChance"] = $mapZone->getFindingChances();
                break;
            case 10:
                //This returns information about the players in the game and their relationships
                $view = partyZonePlayerController::getPlayerDetails($profile->getAvatar());
                break;
            case 11:
                //This returns information about what can be taught to another player
                $view = partyZonePlayerController::getResearchTeaching($profile->getAvatar(),$data);
                break;
            case 12:
                //This returns information about a players profile
                $view = profileAchievementController::newController($data,$profile->getProfileID());
                $viewHUD = false;
                break;
            case 13:
                //This returns information about a players profile
                $view = profileController::findProfiles($data);
                $viewHUD = false;
                break;
            case 14:
                //This returns information about a players profile
                $view = mapPlayerController::getAllMaps($profile);
                $viewHUD = false;
                break;
            default:
                $view = array("ERROR" => "Somehow you found a 2nd error, this shouldn't be seen - Control =".$control);
        }
        if ($viewHUD === true) {
            $tempHUD = HUDController::getHUDStats($profile->getAvatar());
            $HUD = $tempHUD->returnVars();
            echo json_encode(array("view" => $view, "HUD" => $HUD));
        } else {
            echo json_encode(array("view" => $view));
        }
    }
}