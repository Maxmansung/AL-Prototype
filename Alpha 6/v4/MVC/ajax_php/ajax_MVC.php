<?php
if (isset($_POST["type"])) {
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
    include_once(PROJECT_ROOT."/MVC/filesInclude.php");
    $type = intval(preg_replace('#[^0-9]#i', '', $_POST['type']));
    $response = profileController::userlogin();
    $excludedRequests = array(226,225,213,204,198,197,196,49);
    $check = in_array($type,$excludedRequests);
    if (!array_key_exists("SUCCESS",$response) && $check === false ){
        echo json_encode($response);
    } else {
        if (isset($response["SUCCESS"])) {
            $profile = new profileController($response["SUCCESS"]);
        } else {
            $profile = new profileController("");
        }
        $control = intval(preg_replace('#[^0-9]#i', '', $_POST['view']));
        if ($profile->getNightfall() === 1 && $type !== 47 && $control!== 15){
            echo json_encode(array("ERROR"=>200));
        } else {
            $ingameArray = [1, 2, 3, 5, 6, 8, 9, 11, 14, 16, 17, 18, 20, 21, 22, 23, 26, 27, 28, 29, 30, 31, 32, 33, 34, 41, 43, 44, 45, 48, 50, 51, 52, 202];
            $gameCheck = true;
            if (in_array($type, $ingameArray)) {
                if ($profile->getGameStatus() !== "in") {
                    echo json_encode(array("ERROR" => 11));
                    $gameCheck = false;
                }
            }
            if ($gameCheck === true) {
                $data1 = htmlentities($_POST['data1'], ENT_QUOTES | ENT_SUBSTITUTE);
                $data2 = htmlentities($_POST['data2'], ENT_QUOTES | ENT_SUBSTITUTE);
                $data3 = htmlentities($_POST['data3'], ENT_QUOTES | ENT_SUBSTITUTE);
                $data4 = htmlentities($_POST['data4'], ENT_QUOTES | ENT_SUBSTITUTE);
                $data5 = htmlentities($_POST['data5'], ENT_QUOTES | ENT_SUBSTITUTE);
                $data6 = htmlentities($_POST['data6'], ENT_QUOTES | ENT_SUBSTITUTE);
                switch ($type) {
                    //UNUSED FUNCTIONS:
                    /*
                    case 10:
                    case 12:
                    case 19:
                    case 24:
                    case 25:
                    case 39:
                    case 42:
                    case 47:
                    */
                    //Used to show the Alerts
                    case 0:
                        //Used to show an individual player
                    case 2:
                        //Used to get the Main game page information
                    case 9:
                    case 11:
                    case 41:
                        //This is used to show the Profile Page
                    case 35:
                        //This is used to show the Profile Edit page
                    case 36:
                        //This is used to search for other players profiles
                    case 38:
                        //This is used to show the Join Game Page
                    case 49;
                        //This is used to show the deathscreen page
                    case 53:
                        //This is used to show the join game page
                    case 188:
                        //This is used to show the leaderboards
                    case 192:
                        //This is used to get the posts for a forum thread
                    case 193:
                        //This is used to get the forum threads
                    case 206:
                        //This is used to get the news edit view
                    case 210:
                        //This is used to get all of the current map views
                    case 211:
                        //This is used to get all the detail of a single map for editing
                    case 218:
                        //This is used to get all the open reports
                    case 220:
                        //This is used to show the admin page of searched players
                    case 225:
                        //This is used to show the news page
                    case 226:
                        //This is used to show a single news page
                    case 229:
                        //This is used to show the test items finding page
                        $response = array("SUCCESS" => true);
                        //No actions performed
                        break;
                    case 1:
                        //Used to perform a recipe
                        $response = playerMapZoneController::useRecipe($data3, $profile->getAvatar());
                        //Returns ERROR or ALERT or SUCCESS
                        break;
                    case 3:
                        //Used to perform research
                        $response = buildingItemController::performResearch($profile->getAvatar());
                        //Returns ERROR or ALERT or SUCCESS
                        break;
                    case 5:
                        //Used for building in adding stamina to buildings
                        $response = buildingItemController::buildBuilding($profile->getAvatar(), $data1, $data3, $data4);
                        //Returns ERROR or SUCCESS
                        break;
                    case 6:
                        //Used to change a players ready status
                        $response = HUDController::changeReady($profile);
                        //Returns ERROR, ALERT or SUCCESS
                        break;
                    case 7:
                        //Used to confirm a players death
                        $response = dayEndingFunctions::confirmDeath($profile);
                        //Returns ERROR
                        break;
                    case 8:
                        //Used to complete a research
                        $response = buildingItemController::completeResearch($profile->getAvatar(), $data3);
                        //Returns ERROR or ALERT
                        break;
                    case 14:
                        //Used when a player reinforces the fence
                        $response = buildingItemController::impactLock($profile->getAvatar(), "Fence");
                        //Returns ERROR or SUCCESS
                        break;
                    case 16:
                        //Used to drop an item into the storage
                        $response = buildingItemController::storageItemTransfer($data3, $profile->getAvatar(),"backpack");
                        //Returns ERROR or SUCCESS
                        break;
                    case 17:
                        //Used to pick up an item from the storage
                        $response = buildingItemController::storageItemTransfer($data3, $profile->getAvatar(),"storage");
                        //Returns ERROR or SUCCESS
                        break;
                    case 18:
                        //Used when a player reinforces the chest
                        $response = buildingItemController::impactLock($profile->getAvatar(), "Chest");
                        //Returns ERROR or SUCCESS
                        break;
                    case 20:
                        //Used when a player moves on the map
                        $response = playerMapZoneController::moveAvatar($profile->getAvatar(), $data3);
                        //Returns ERROR or SUCCESS
                        break;
                    case 21:
                        //Used when a player drops an item
                        $response = playerMapZoneController::dropItem($data3, $profile->getAvatar(),"backpack");
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
                        $response = partyZonePlayerController::cancelJoin($profile->getAvatar());
                        //Returns ERROR or ALERT
                        break;
                    case 33:
                        //Used to cancel a request and make a new one
                        $response = partyZonePlayerController::joinPartyOverride($profile->getAvatar(), $data1);
                        //Returns ERROR or ALERT
                        break;
                    case 34:
                        //Used when a player wants to teach another player something
                        $response = partyZonePlayerController::teachPlayerResearch($profile->getAvatar(), $data1, $data2);
                        //Returns ERROR or ALERT
                        break;
                    case 37:
                        //Used to log the player out of the game
                        $response = $profile->destroysession();
                        //Returns ERROR only
                        break;
                    case 40:
                        //This is used to join a player to a game
                        $response = newMapJoinController::addAvatar($data1, $profile);
                        //Returns ERROR or ALERT
                        break;
                    case 43;
                        //This is used when a shrine is worshiped at
                        $response = playerMapZoneController::worshipShrine($data1, $profile->getAvatar());
                        break;
                    case 44:
                        //This is used to pick up an item from the ground
                        $response = playerMapZoneController::dropItem($data3, $profile->getAvatar(),"ground");
                        break;
                    //Returns ERROR or SUCCESS
                    case 45:
                        //Used to upgrade sleeping bag
                        $response = buildingItemController::upgradeBackpack($profile->getAvatar(), $data3);
                        //Returns ERROR or SUCCESS
                        break;
                    case 46:
                        //Used to send a private message to another player
                        $messageText = $_POST['text'];
                        $messageTitle = $_POST['title'];
                        $response = privateMessagesController::createNewMessage($profile->getAvatar(), $data1, $messageTitle, $messageText);
                        //Returns ERROR or ALERT
                        break;
                    case 48:
                        //Used when an item is consumed
                        $response = playerMapZoneController::consumeItem($data3, $profile->getAvatar());
                        break;
                    //Returns ERROR or SUCCESS
                    case 50:
                        //Used when a player wants to join another players party
                        $response = partyZonePlayerController::checkSoloFavour($profile->getAvatar(), $data1);
                        //Returns ERROR or ALERT
                        break;
                    case 51:
                        //Used when a player leave a party
                        $response = partyZonePlayerController::checkTeamFavour($profile->getAvatar());
                        //Returns ERROR or ALERT
                        break;
                    case 52:
                        //Used when a player leave a party
                        $response = partyZonePlayerController::votingOnPlayerFinal($profile->getAvatar(), $data1, "accept");
                        //Returns ERROR or ALERT
                        break;
                    case 184:
                        //Used to report a comment on the news stories
                        $response = reportingController::newReportComment($profile, $data1, $data2);
                        break;
                    //Returns ERROR or ALERT
                    case 185:
                        //Used to comment on the news page
                        $response = newsCommentsController::createComment($profile, $data1, $data2);
                        break;
                    //Returns ERROR or ALERT
                    case 186:
                        //Used to close an alert
                        $response = profileAlertController::removeAlertVisible($profile, $data1);
                        break;
                    //Returns ALERT
                    case 187:
                        //Used to mark alerts as read
                        $response = profileAlertController::markAsRead($profile, $data1);
                        break;
                    //Returns ERROR or ALERT
                    case 189:
                        //This is used for reporting posts
                        $response = reportingController::newReportPost($profile, $data1, $data2, $data3);
                        break;
                    //Returns ERROR or ALERT
                    case 190:
                        //This is used for creating new threads
                        $response = forumThreadController::checkThread($data1, $data2, $data3, $data4, $data5, $profile);
                        break;
                    //Returns ERROR or ALERT
                    case 191:
                        //This is used for posting replies to forum threads
                        $response = forumPostController::createNewPost($data1, $profile, $data2, $data3);
                        break;
                    //Returns ERROR or ALERT
                    case 194:
                        //Used to update the players favourite achievments
                        $response = profileDetailsController::updateFavouriteAchievements($profile, $data1, $data2, $data3, $data4);
                        break;
                    case 195:
                        //Used to update the players profile
                        $response = $profile->updateProfileDetails($data1, $data2, $data3, $data4);
                        //Returns ERROR or ALERT
                        break;
                    case 196:
                        //Used to recover the players password
                        $response = profileController::createRecoveryPassword($data1);
                        //Returns ERROR or ALERT
                        break;
                    case 197:
                        //Used to create a new account within the game
                        $response = $profile->signup($data1, $data2, $data3, "GreatSnowman");
                        break;
                    case 198:
                        //Used to log into the game
                        $response = $profile->login($data1, $data2, $data3, false);
                        //Returns ERROR or COOKIES
                        break;
                    case 199:
                        //Used to log out of the game
                        $response = profileController::destroysession();
                        //Returns ERROR
                        break;

                    //200+ functions are used for admin properties

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
                    case 204:
                        //Used for changing the language
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        setcookie('lang', $data1, time() + (86400 * 30), "/", SITE_ADDRESS);
                        $response = array("ALERT" => 17, "DATA" => "None");
                        break;
                    case 205:
                        //Used for posting new News stories
                        $response = newsStoryController::postingNews($profile, $data1, $data2, $data3, "new");
                        break;
                    //Returns ERROR or ALERT
                    case 207:
                        //Used for posting new News stories
                        $response = newsStoryController::postingNews($profile, $data1, $data2, $data3, $data4);
                        break;
                    case 208:
                        //Used for deleting News stories
                        $response = newsStoryController::deleteNewsController($profile, $data1);
                        break;
                    //Returns ERROR or ALERT
                    case 209:
                        //Used for creating new maps
                        $response = newMapJoinController::createNewMap($data1, $data2, $data3, $data4, $profile, $data5);
                        break;
                    //Returns ERROR or ALERT
                    case 212:
                        //Used to delete a map
                        $response = newMapJoinController::deleteMap($profile, $data1, $data2);
                        break;
                    //Returns ERROR or ALERT
                    case 213:
                        //Used to activate an account and join a tutorial game
                        $response = profileController::activateConfirm($data1, $data2);
                        break;
                    case 214:
                        //Used to report a created map that needs to be removed
                        $response = reportingController::newReportCreateMap($profile, $data1, $data2);
                        break;
                    case 215:
                        //Used to edit a player within a game
                        $response = mapPlayerController::editPlayerStats($data1, $data2, $data3, $profile);
                        break;
                    //Returns ERROR or ALERT
                    case 216:
                        //Used to kill a player within a game
                        $response = HUDController::playerDeathKilling($data1, $profile);
                        break;
                    //Returns ERROR or ALERT
                    case 217:
                        //Used to edit a map within a game
                        $response = mapPlayerController::editMapStats($profile, $data1, $data2, $data3);
                        break;
                    //Returns ERROR or ALERT
                    case 219:
                        //Used to mark a report as resolved
                        $response = reportingController::resolveReport($data1, $data2, $profile);
                        break;
                    //Returns ERROR or ALERT
                    case 221:
                        //Used to give a warning to a player
                        $response = profileWarningController::givePlayerWarning($profile, $data1, $data2, $data3);
                        //Returns ERROR or ALERT
                        break;
                    case 222:
                        //Used to change a players rank
                        $response = profileController::changePlayerRank($profile, $data1, $data2);
                        //Returns ERROR or ALERT
                        break;
                    case 223:
                        //Used to delete a forum post
                        $response = forumPostController::modifyPost($profile, $data1, $data2, $data3, "Delete");
                        //Returns ERROR or ALERT
                        break;
                    case 224:
                        //Used to edit a forum post
                        $response = forumPostController::modifyPost($profile, $data1, $data2, $data3, "Edit");
                        //Returns ERROR or ALERT
                        break;
                    case 227:
                        //Used to delete a comment post
                        $response = newsCommentsController::modifyComment($profile, $data1, $data2, "Delete");
                        //Returns ERROR or ALERT
                        break;
                    case 228:
                        //Used to delete a comment post
                        $response = newsCommentsController::modifyComment($profile, $data1, $data2, "Edit");
                        //Returns ERROR or ALERT
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
                        case "HUD":
                            $view = "";
                            break;
                        case 1:
                            $view = joinGameView::createView($profile);
                            $viewHUD = false;
                            break;
                        case 2:
                            $view = profileAchievements::getView($data1);
                            $viewHUD = false;
                            break;
                        case 3:
                            //This finds player profiles that match a string
                            $view = profileSearchView::findProfiles($data1);
                            $viewHUD = false;
                            break;
                        case 4:
                            //This finds the threads that match a group
                            $view = forumThreadController::getAllThreads($data1, $data2, $profile);
                            $viewHUD = false;
                            break;
                        case 5:
                            //This finds the posts that match a thread
                            $view['posts'] = forumPostController::getAllPosts($data1, $data3, $data4, $profile);
                            $view['threads'] = forumThreadController::getAllThreads($data1, $data2, $profile);
                            $viewHUD = false;
                            break;
                        case 6:
                            $view = newsStoryController::getAllNews();
                            $viewHUD = false;
                            break;
                        case 7:
                            $view = mapOverviewEditView::getAllMapsOverview($profile);
                            $viewHUD = false;
                            break;
                        case 8:
                            $view = mapOverviewEditView::getSingleMapDetail($profile, $data1);
                            $viewHUD = false;
                            break;
                        case 9:
                            $view = leaderboardScores::getScoresType($data1);
                            $viewHUD = false;
                            break;
                        case 10:
                            $view = reportingController::getAllReports(false, $profile);
                            $viewHUD = false;
                            break;
                        case 11:
                            $view = profileSearchViewAdmin::searchSpiritResults($data1, $profile);
                            $viewHUD = false;
                            break;
                        case 12:
                            $view = profileAlertController::getAllAlerts($profile);
                            $viewHUD = false;
                            break;
                        case 13:
                            $view = newsStoryController::getNewsPage($data1);
                            $viewHUD = false;
                            break;
                        case 14:
                            $view = ingameOverview::createIngameOverview($profile, $data1, $data2);
                            break;
                        case 15:
                            $view = otherAvatarView::createNewView($profile->getAvatar(), $data1);
                            break;
                        case 16:
                            $view = shrineView::createTestView($profile->getAvatar());
                            break;
                        case 17:
                            $view = mapView::getView($profile->getAvatar());
                            break;
                        case 18:
                            $view = deathScreenView::getDeathView($profile->getProfileID());
                            $viewHUD = false;
                            break;
                        case 19:
                            $view = testChancesView::createView($data1);
                            $viewHUD = false;
                            break;
                        default:
                            $view = array("ERROR" => "Somehow you found a 2nd error, this shouldn't be seen - Control =" . $control);
                            $viewHUD = false;
                    }
                    if ($viewHUD === true) {
                        $HUD = HUDView::createView($profile);
                        echo json_encode(array("view" => $view, "HUD" => $HUD));
                    } else {
                        echo json_encode(array("view" => $view));
                    }
                }
            }
        }
    }
} else {include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
    include_once(PROJECT_ROOT."/MVC/filesInclude.php");
    $response = profileController::userlogin();
    if (!array_key_exists("ERROR", $response)) {
        if (array_key_exists("ALERT",$response)){
            $response = profileController::userlogin();
        }
        $profile = new profileController($response["SUCCESS"]);
        if ($profile->getGameStatus() === "death"){
            $death = new deathScreenController($profile->getProfileID());
            if ($death->getProfileID() !== $profile->getProfileID()){
                $profile->setGameStatus("ready");
                $profile->uploadProfile();
            }
        }
    } else {
        $profile = new profileController("");
    }
}