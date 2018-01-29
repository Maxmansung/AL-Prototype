<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));

//CONNECTION CLASSES
include(PROJECT_ROOT."/MVC/connection/db_conx.php");

//DATA CLASSES
include(PROJECT_ROOT."/MVC/data/emails.php");
include(PROJECT_ROOT."/MVC/data/data.php");
include(PROJECT_ROOT."/MVC/data/buildingLevels.php");
include(PROJECT_ROOT."/MVC/data/CI_Input.php");

//CONTROLLER CLASSES
include(PROJECT_ROOT."/MVC/controller/achievementController.php");
include(PROJECT_ROOT."/MVC/controller/avatarController.php");
include(PROJECT_ROOT."/MVC/controller/biomeTypeController.php");
include(PROJECT_ROOT."/MVC/controller/buildingController.php");
include(PROJECT_ROOT."/MVC/controller/buildingItemController.php");
include(PROJECT_ROOT."/MVC/controller/buildingType.php");
include(PROJECT_ROOT."/MVC/controller/chatlogAllController.php");
include(PROJECT_ROOT."/MVC/controller/dayEndingFunctions.php");
include(PROJECT_ROOT."/MVC/controller/deathCauseController.php");
include(PROJECT_ROOT."/MVC/controller/deathScreenController.php");
include(PROJECT_ROOT."/MVC/controller/firepitController.php");
include(PROJECT_ROOT."/MVC/controller/forumCatagoriesController.php");
include(PROJECT_ROOT."/MVC/controller/forumPostController.php");
include(PROJECT_ROOT."/MVC/controller/forumThreadController.php");
include(PROJECT_ROOT."/MVC/controller/HUDController.php");
include(PROJECT_ROOT."/MVC/controller/itemController.php");
include(PROJECT_ROOT."/MVC/controller/lockController.php");
include(PROJECT_ROOT."/MVC/controller/mapController.php");
include(PROJECT_ROOT."/MVC/controller/mapPlayerController.php");
include(PROJECT_ROOT."/MVC/controller/nameGeneratorController.php");
include(PROJECT_ROOT."/MVC/controller/newMapJoinController.php");
include(PROJECT_ROOT."/MVC/controller/partyController.php");
include(PROJECT_ROOT."/MVC/controller/partyZonePlayerController.php");
include(PROJECT_ROOT."/MVC/controller/playerMapZoneController.php");
include(PROJECT_ROOT."/MVC/controller/privateMessagesController.php");
include(PROJECT_ROOT."/MVC/controller/profileAchievementController.php");
include(PROJECT_ROOT."/MVC/controller/profileController.php");
include(PROJECT_ROOT."/MVC/controller/profileImagesController.php");
include(PROJECT_ROOT."/MVC/controller/recipeController.php");
include(PROJECT_ROOT."/MVC/controller/shrineController.php");
include(PROJECT_ROOT."/MVC/controller/shrinePlayerView.php");
include(PROJECT_ROOT."/MVC/controller/statusesController.php");
include(PROJECT_ROOT."/MVC/controller/storageController.php");
include(PROJECT_ROOT."/MVC/controller/zoneController.php");

//VIEW CLASSES
include(PROJECT_ROOT."/MVC/view/constructionView.php");
include(PROJECT_ROOT."/MVC/view/statusView.php");
include(PROJECT_ROOT."/MVC/view/deathScreenView.php");
include(PROJECT_ROOT."/MVC/view/diaryView.php");
include(PROJECT_ROOT."/MVC/view/HUDView.php");
include(PROJECT_ROOT."/MVC/view/mapView.php");
include(PROJECT_ROOT."/MVC/view/specialZoneView.php");
include(PROJECT_ROOT."/MVC/view/nightfallView.php");

?>