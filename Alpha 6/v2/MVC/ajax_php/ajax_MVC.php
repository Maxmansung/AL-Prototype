<?php
if (isset($_POST["type"])) {
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
    include_once(PROJECT_ROOT."/MVC/filesInclude.php");
    $type = intval(preg_replace('#[^0-9]#i', '', $_POST['type']));
    $response = profileController::userlogin();
    $excludedRequests = array(198,197,196,49);
    $check = in_array($type,$excludedRequests);
    if (array_key_exists("ERROR",$response) && $check === false ){
        echo json_encode($response);
    } else {
        if (isset($response["SUCCESS"])) {
            $profile = new profileController($response["SUCCESS"]);
        } else {
            $profile = new profileController("");
        }
        $control = intval(preg_replace('#[^A-Za-z0-9 ?()]#i', '', $_POST['view']));
        if ($profile->getNightfall() === 1 && $type !== 47 && $control!== 15){
            echo json_encode(array("ERROR"=>200));
        } else {
            $data1 = $_POST['data1'];
            $data2 = $_POST['data2'];
            $data3 = $_POST['data3'];
            $data4 = $_POST['data4'];
            $data5 = $_POST['data5'];
            $data6 = $_POST['data6'];
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
                case 49:
                    //This is used to show the news page
                    $response = array("SUCCESS" => true);
                    //No actions performed
                    break;
                case 1:
                    //Used to perform a recipe
                    $response = playerMapZoneController::useRecipe($data1, $profile->getAvatar());
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
                    $spent = intval(preg_replace('#[^0-9]#i', '', $_POST['cost']));
                    $response = buildingItemController::buildBuilding($data1, $profile->getAvatar(), $spent);
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
                    $response = buildingItemController::completeResearch($profile->getAvatar(),intval($data1));
                    //Returns ERROR or ALERT
                    break;
                case 11:
                    //Used when an item is dropped into the firepit
                    $response = buildingItemController::firepitDrop($data1, $profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 14:
                    //Used when a player reinforces a lock
                    $response = buildingItemController::impactLock($profile->getAvatar(),"break", $data1);
                    //Returns ERROR or SUCCESS
                    break;
                case 16:
                    //Used to drop an item into the storage
                    $response = buildingItemController::storageItemTransfer($data1, $profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 17:
                    //Used to upgrade the storage building
                    $response = buildingItemController::upgradeStorage($profile->getAvatar());
                    //Returns ERROR or SUCCESS
                    break;
                case 18:
                    //Used when a player reinforces a lock
                    $response = buildingItemController::impactLock($profile->getAvatar(), "reinforce", $data1);
                    //Returns ERROR or SUCCESS
                    break;
                case 20:
                    //Used when a player moves on the map
                    $response = playerMapZoneController::moveAvatar($profile->getAvatar(), $data1);
                    //Returns ERROR or SUCCESS
                    break;
                case 44:
                case 21:
                    //Used when a player drops an item
                    $response = playerMapZoneController::dropItem($data1, $profile->getAvatar());
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
                    $response = partyZonePlayerController::kickPlayer($profile->getAvatar(), $data1);
                    //Returns ERROR or ALERT
                    break;
                case 28:
                    //Used when a player wants to accept a player to the party
                    $response = partyZonePlayerController::votingOnPlayer($profile->getAvatar(), $data1, "accept");
                    //Returns ERROR or ALERT
                    break;
                case 29:
                    //Used when a player wants to reject a player from the party
                    $response = partyZonePlayerController::votingOnPlayer($profile->getAvatar(), $data1, "reject");
                    //Returns ERROR or ALERT
                    break;
                case 30:
                    //Used when a player wants to join another players party
                    $response = partyZonePlayerController::joinParty($profile->getAvatar(), $data1);
                    //Returns ERROR or ALERT
                    break;
                case 31:
                    //Used when a player wants to change their groups name
                    $response = partyZonePlayerController::changeGroupName($profile->getAvatar(), $data1);
                    //Returns ERROR or ALERT
                    break;
                case 32:
                    //Used when a player wants to cancel a request to join a party
                    $response = partyZonePlayerController::cancelJoin($profile->getAvatar(), $data1);
                    //Returns ERROR or ALERT
                    break;
                case 33:
                    //Used when a player wants to check if they can teach another player something
                    $response = partyZonePlayerController::getResearchTeaching($profile->getAvatar(), $data1);
                    //Returns ERROR or ALERT
                    break;
                case 34:
                    //Used when a player wants to teach another player something
                    $player = preg_replace('#[^A-Za-z0-9_\s]#i', '', $_POST['other']);
                    $response = partyZonePlayerController::teachPlayerResearch($player, $profile->getAvatar(), $data1);
                    //Returns ERROR or ALERT
                    break;
                case 37:
                    //Used to log the player out of the game
                    $response = $profile->destroysession();
                    //Returns ERROR only
                    break;
                case 40:
                    //This is used to join a player to a game
                    $response = newMapJoinController::addAvatar($data1, $profile->getProfileID());
                    //Returns ERROR or ALERT
                    break;
                case 41:
                    //This is used to join a player to a game
                    $response = newMapJoinController::deleteGame($data1, $profile->getAccountType());
                    //Returns ERROR
                    break;
                case 43;
                    //This is used when a shrine is worshiped at
                    $response = playerMapZoneController::worshipShrine($data1, $profile->getAvatar());
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
                    $response = privateMessagesController::createNewMessage($profile->getAvatar(),$data1,$messageTitle,$messageText);
                    //Returns ERROR or ALERT
                    break;
                case 48:
                    //Used when an item is consumed
                    $response = playerMapZoneController::consumeItem($data1,$profile->getAvatar());
                    break;
                    //Returns ERROR or SUCCESS
                case 196:
                    //Used to recover the players password
                    $response = profileController::createRecoveryPassword($data1);
                    break;
                    //Returns ERROR or ALERT
                case 197:
                    //Used to create a new account within the game
                    $response = $profile->signup($data1,$data2,$data3,$data4);
                    break;
                case 198:
                    //Used to log into the game
                    $response = $profile->login($data1,$data2,$data3);
                    break;
                    //Returns ERROR or COOKIES
                case 199:
                    //Used to log out of the game
                    $response = profileController::destroysession();
                    break;
                    //Returns ERROR

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
                    case "x":
                        //This returns the avatar view item

                        //$view = new constructionView($profile->getAvatar());
                        //$view = $view->returnVars();
                        break;
                    case 1:
                        $view = newsStoryController::getAllNews();
                        $viewHUD = false;
                        break;
                    case 2:
                        $view = profileAchievements::getView($data1);
                        $viewHUD = false;
                        break;
                    default:
                        $view = array("ERROR" => "Somehow you found a 2nd error, this shouldn't be seen - Control =" . $control);
                }
                if ($viewHUD === true) {
                    //$tempHUD = new HUDView($profile->getAvatar());
                    //$HUD = $tempHUD->returnVars();
                    $HUD = array("ERROR"=>"No HUD created currently");
                    echo json_encode(array("view" => $view, "HUD" => $HUD));
                } else {
                    echo json_encode(array("view" => $view));
                }
            }
        }
    }
} else {include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
    include_once(PROJECT_ROOT."/MVC/filesInclude.php");
    $response = profileController::userlogin();
    if (!array_key_exists("ERROR", $response)) {
        $profile = new profileController($response["SUCCESS"]);
    } else {
        $profile = new profileController("");
    }
}