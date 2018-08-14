<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));

//FACTORY CLASSES
include_once(PROJECT_ROOT . "/MVC/factory/factoryClasses.php");

//CONNECTION CLASSES
include_once(PROJECT_ROOT."/MVC/connection/db_conx.php");

//DATA CLASSES
include_once(PROJECT_ROOT."/MVC/data/emails.php");
include_once(PROJECT_ROOT."/MVC/data/data.php");
include_once(PROJECT_ROOT."/MVC/data/buildingLevels.php");
include_once(PROJECT_ROOT."/MVC/data/CI_Input.php");

//CONTROLLER CLASSES
include_once(PROJECT_ROOT."/MVC/controller/achievementController.php");
include_once(PROJECT_ROOT."/MVC/controller/avatarController.php");
include_once(PROJECT_ROOT."/MVC/controller/chatlogAllController.php");
include_once(PROJECT_ROOT."/MVC/controller/deathScreenController.php");
include_once(PROJECT_ROOT."/MVC/controller/forumCatagoriesController.php");
include_once(PROJECT_ROOT."/MVC/controller/forumPostController.php");
include_once(PROJECT_ROOT."/MVC/controller/forumThreadController.php");
include_once(PROJECT_ROOT."/MVC/controller/lockController.php");
include_once(PROJECT_ROOT."/MVC/controller/mapController.php");
include_once(PROJECT_ROOT."/MVC/controller/modTrackingController.php");
include_once(PROJECT_ROOT."/MVC/controller/nameGeneratorController.php");
include_once(PROJECT_ROOT."/MVC/controller/newsCommentsController.php");
include_once(PROJECT_ROOT."/MVC/controller/newsStoryController.php");
include_once(PROJECT_ROOT."/MVC/controller/partyController.php");
include_once(PROJECT_ROOT."/MVC/controller/privateMessagesController.php");
include_once(PROJECT_ROOT."/MVC/controller/profileAlertController.php");
include_once(PROJECT_ROOT."/MVC/controller/profileController.php");
include_once(PROJECT_ROOT."/MVC/controller/profileDetailsController.php");
include_once(PROJECT_ROOT."/MVC/controller/profileImagesController.php");
include_once(PROJECT_ROOT."/MVC/controller/profileWarningController.php");
include_once(PROJECT_ROOT."/MVC/controller/reportingController.php");
include_once(PROJECT_ROOT."/MVC/controller/shrineActionsController.php");
include_once(PROJECT_ROOT."/MVC/controller/storageController.php");
include_once(PROJECT_ROOT."/MVC/controller/zoneController.php");

//COMBINED CONTROLLER CLASSES
include_once(PROJECT_ROOT . "/MVC/overviewController/buildingItemController.php");
include_once(PROJECT_ROOT . "/MVC/overviewController/dayEndingFunctions.php");
include_once(PROJECT_ROOT . "/MVC/overviewController/HUDController.php");
include_once(PROJECT_ROOT . "/MVC/overviewController/mapPlayerController.php");
include_once(PROJECT_ROOT . "/MVC/overviewController/newMapJoinController.php");
include_once(PROJECT_ROOT . "/MVC/overviewController/partyZonePlayerController.php");
include_once(PROJECT_ROOT . "/MVC/overviewController/playerMapZoneController.php");

//VIEW CLASSES
include_once(PROJECT_ROOT . "/MVC/view/buildingsListHelp.php");
include_once(PROJECT_ROOT . "/MVC/view/buildingListSingle.php");
include_once(PROJECT_ROOT . "/MVC/view/buildingView.php");
include_once(PROJECT_ROOT . "/MVC/view/deathScreenView.php");
include_once(PROJECT_ROOT . "/MVC/view/equipmentView.php");
include_once(PROJECT_ROOT . "/MVC/view/HUDView.php");
include_once(PROJECT_ROOT . "/MVC/view/ingameOverview.php");
include_once(PROJECT_ROOT . "/MVC/view/itemView.php");
include_once(PROJECT_ROOT . "/MVC/view/joinGameView.php");
include_once(PROJECT_ROOT . "/MVC/view/leaderboardScores.php");
include_once(PROJECT_ROOT . "/MVC/view/mapOverviewEditView.php");
include_once(PROJECT_ROOT . "/MVC/view/mapView.php");
include_once(PROJECT_ROOT . "/MVC/view/otherAvatarView.php");
include_once(PROJECT_ROOT . "/MVC/view/profileAchievements.php");
include_once(PROJECT_ROOT . "/MVC/view/profileSearchView.php");
include_once(PROJECT_ROOT . "/MVC/view/profileSearchViewAdmin.php");
include_once(PROJECT_ROOT . "/MVC/view/shrineView.php");
include_once(PROJECT_ROOT . "/MVC/view/testChancesView.php");
include_once(PROJECT_ROOT . "/MVC/view/zoneDetailView.php");