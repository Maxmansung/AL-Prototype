<?php
if (isset($_POST["type"])) {
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
    include_once(PROJECT_ROOT."/MVC/filesInclude.php");
    $response = profileController::userlogin();
    if (array_key_exists("ERROR",$response)){
        echo json_encode($response);
    } else {
        $profile = new profileController($response["SUCCESS"]);
        $type = intval(preg_replace('#[^0-9]#i', '', $_POST['type']));
        $control = intval(preg_replace('#[^A-Za-z0-9 ?()]#i', '', $_POST['view']));
        if ($profile->getNightfall() === 1 && $type !== 47 && $control!== 15){
            echo json_encode(array("ERROR"=>200));
        } else {
            $data = preg_replace('#[^A-Za-z0-9 ?()]#i', '', $_POST['data']);
            switch ($type) {
                case 0:
                    //Used to show the avatar screen
                case 9:
                    //Used to show the death screen
                case 10:
                    //Used to show the firepit screen
                case 12:
                    //Used to show the Actions screen
                case 19:
                    //Used to show the map screen
                case 24:
                    //Used to show the a single zones information
                case 25:
                    //Used to show the a single zones information
                case 35:
                    //Used to show the players profile page
                case 36:
                    //Used to show players profile edit page
                case 38:
                    //Used to show the players that are searched for
                case 39:
                    //Used to show the players that are searched for
                case 42:
                    //This is used to show the special buildings page
                case 47:
                    //This is used to show the nightfall page
                    $response = array("SUCCESS" => true);
                    //No actions performed
                    break;
                case 1:
                    //Used to perform a recipe
                    $response = playerMapZoneController::useRecipe($data, $profile->getAvatar());
                    //Returns ERROR or ALERT or SUCCESS
                    break;
                case 2:
                    //Used to upgrade sleeping bag
                    $response = buildingItemController::upgradeSleepingBag($profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 3:
                    //Used to perform research
                    $response = buildingItemController::performResearch($profile->getAvatar());
                    //Returns ERROR or ALERT or SUCCESS
                    break;
                case 5:
                    //Used for building in adding stamina to buildings
                    $response = buildingItemController::buildBuilding($data, $profile->getAvatar(), 1);
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
                    //Returns ERROR
                    break;
                case 8:
                    //Used to complete a research
                    $response = buildingItemController::completeResearch($profile->getAvatar(),intval($data));
                    //Returns ERROR or ALERT
                    break;
                case 11:
                    //Used when an item is dropped into the firepit
                    $response = buildingItemController::firepitDrop($data, $profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 14:
                    //Used when a player reinforces a lock
                    $response = buildingItemController::impactLock($profile->getAvatar(),"break", $data);
                    //Returns ERROR or SUCCESS
                    break;
                case 16:
                    //Used to drop an item into the storage
                    $response = buildingItemController::storageItemTransfer($data, $profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 17:
                    //Used to upgrade the storage building
                    $response = buildingItemController::upgradeStorage($profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 18:
                    //Used when a player reinforces a lock
                    $response = buildingItemController::impactLock($profile->getAvatar(), "reinforce", $data);
                    //Returns ERROR or SUCCESS
                    break;
                case 20:
                    //Used when a player moves on the map
                    $response = playerMapZoneController::moveAvatar($profile->getAvatar(), $data);
                    //Returns ERROR or SUCCESS
                    break;
                case 44:
                case 21:
                    //Used when a player drops an item
                    $response = playerMapZoneController::dropItem($data, $profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 22:
                    //Used when a player searches the zone
                    $response = playerMapZoneController::searchZone($profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 23:
                    //Used when a player trys to destroy the zone
                    $response = playerMapZoneController::destroyBiome($profile->getAvatar());
                    //Returns ERROR or ALERT
                    break;
                case 26:
                    //Used when a player wants to leave a party
                    $response = partyZonePlayerController::leaveParty($profile->getAvatar());
                    //Returns ERROR or ALERT
                    break;
                case 27:
                    //Used when a player wants to kick a player from the party
                    $response = partyZonePlayerController::kickPlayer($profile->getAvatar(), $data);
                    //Returns ERROR or ALERT
                    break;
                case 28:
                    //Used when a player wants to accept a player to the party
                    $response = partyZonePlayerController::votingOnPlayer($profile->getAvatar(), $data, "accept");
                    //Returns ERROR or ALERT
                    break;
                case 29:
                    //Used when a player wants to reject a player from the party
                    $response = partyZonePlayerController::votingOnPlayer($profile->getAvatar(), $data, "reject");
                    //Returns ERROR or ALERT
                    break;
                case 30:
                    //Used when a player wants to join another players party
                    $response = partyZonePlayerController::joinParty($profile->getAvatar(), $data);
                    //Returns ERROR or ALERT
                    break;
                case 31:
                    //Used when a player wants to change their groups name
                    $response = partyZonePlayerController::changeGroupName($profile->getAvatar(), $data);
                    //Returns ERROR or ALERT
                    break;
                case 32:
                    //Used when a player wants to cancel a request to join a party
                    $response = partyZonePlayerController::cancelJoin($profile->getAvatar(), $data);
                    //Returns ERROR or ALERT
                    break;
                case 33:
                    //Used when a player wants to check if they can teach another player something
                    $response = partyZonePlayerController::getResearchTeaching($profile->getAvatar(), $data);
                    //Returns ERROR or ALERT
                    break;
                case 34:
                    //Used when a player wants to teach another player something
                    $player = preg_replace('#[^A-Za-z0-9_\s]#i', '', $_POST['other']);
                    $response = partyZonePlayerController::teachPlayerResearch($player, $profile->getAvatar(), $data);
                    //Returns ERROR or ALERT
                    break;
                case 37:
                    //Used to log the player out of the game
                    $response = $profile->destroysession();
                    //Returns ERROR only
                    break;
                case 40:
                    //This is used to join a player to a game
                    $response = newMapJoinController::addAvatar($data, $profile->getProfileID());
                    //Returns ERROR or ALERT
                    break;
                case 41:
                    //This is used to join a player to a game
                    $response = newMapJoinController::deleteGame($data, $profile->getAccountType());
                    //Returns ERROR
                    break;
                case 43;
                    //This is used when a shrine is worshiped at
                    $response = playerMapZoneController::worshipShrine($data, $profile->getAvatar());
                    break;
                case 45:
                    //Used to upgrade sleeping bag
                    $response = buildingItemController::upgradeBackpack($profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 46:
                    //Used to send a private message to another player
                    $messageText = $_POST['text'];
                    $messageTitle = $_POST['title'];
                    $response = privateMessagesController::createNewMessage($profile->getAvatar(),$data,$messageTitle,$messageText);
                    //Returns ERROR or ALERT
                    break;

                //200+ functions are used only for testing and can be removed from the main game

                case 201:
                    //Used for the insta-Death button
                    $response = HUDController::playerDeathButton($profile->getAvatar());
                    //Returns ERROR
                    break;
                case 202:
                    //Used for stamina refreshing
                    $response = HUDController::refreshStamina($profile->getAvatar());
                    //Returns ERROR
                    break;
                case 203:
                    //Used for ending the day
                    $response = HUDController::adminDayEnding($profile->getProfileID());
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
            } //Alerts can also be returned to be processed differently from errors
            elseif (array_key_exists("ALERT", $response)) {
                echo json_encode($response);
            } //Success then continues onto the view array
            else {

                //THIS THEN CHOOSES HOW TO RESPOND TO THE PAGE, THESE ARRAYS CAN BE QUITE LARGE AND SO ARE ONLY USED IN SUCCESSFUL EVENTS

                $viewHUD = true;
                switch ($control) {
                    case 0:
                        //This returns the avatar view item
                        $view = new constructionView($profile->getAvatar());
                        $view = $view->returnVars();
                        break;
                    case 1:
                        //No longer used
                    case 2:
                        //This returns the death screen view
                        $view = new deathScreenView($profile->getProfileID());
                        $view = $view->returnVars();
                        $viewHUD = false;
                        break;
                    case 4:
                        //This returns the diary screen view
                        $temp = new diaryView($profile->getAvatar(), $data);
                        $view = $temp->returnVars();
                        break;
                    case 5:
                        //This returns the overview screen
                        $view = new specialZoneView($profile->getAvatar());
                        $view = $view->returnVars();
                        break;
                    case 7:
                        //This returns the map screen
                        $mapZone = mapView::getCurrentZoneInfo($profile->getAvatar());
                        $view = $mapZone->arrayView($profile->getAvatar());
                        break;
                    case 8:
                        //This returns the information only about a single zone
                        $view = mapView::getZoneInfo($data, $profile->getAvatar());
                        $view = $view->returnVars();
                        break;
                    case 9:
                        //This returns information about the players items only
                        $mapZone = mapView::getCurrentZoneInfo($profile->getAvatar());
                        $view = $mapZone->allItemsView($profile->getAvatar());
                        $view["findingChance"] = $mapZone->getFindingChances();
                        break;
                    case 10:
                        //This returns information about the players in the game and their relationships
                        $view = partyZonePlayerController::getPlayerDetails($profile->getAvatar());
                        break;
                    case 11:
                        //This returns information about what can be taught to another player
                        $view = partyZonePlayerController::getResearchTeaching($profile->getAvatar(), $data);
                        break;
                    case 12:
                        //This returns information about a players profile
                        $view = profileAchievementController::newController($data, $profile->getProfileID());
                        $viewHUD = false;
                        break;
                    case 13:
                        //This finds player profiles that match a string
                        $view = profileController::findProfiles($data);
                        $viewHUD = false;
                        break;
                    case 14:
                        //This returns all of the maps available
                        $view = mapPlayerController::getAllMaps($profile);
                        $viewHUD = false;
                        break;
                    case 15:
                        //This returns the nightfall timer and any other required information
                        $nightfall = new nightfallView();
                        $view = $nightfall->returnVars();
                        $viewHUD = false;
                        break;
                    case 16:
                        //This returns information about a players profile
                        $view = profileAchievementController::editProfileController($profile->getProfileID());
                        $viewHUD = false;
                        break;
                    default:
                        $view = array("ERROR" => "Somehow you found a 2nd error, this shouldn't be seen - Control =" . $control);
                }
                if ($viewHUD === true) {
                    $tempHUD = new HUDView($profile->getAvatar());
                    $HUD = $tempHUD->returnVars();
                    echo json_encode(array("view" => $view, "HUD" => $HUD));
                } else {
                    echo json_encode(array("view" => $view));
                }
            }
        }
    }
}