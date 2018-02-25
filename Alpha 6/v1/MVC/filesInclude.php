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
include(PROJECT_ROOT . "/MVC/baseController/buildingType.php");
include(PROJECT_ROOT."/MVC/controller/chatlogAllController.php");
include(PROJECT_ROOT."/MVC/controller/deathCauseController.php");
include(PROJECT_ROOT."/MVC/controller/deathScreenController.php");
include(PROJECT_ROOT."/MVC/controller/firepitController.php");
include(PROJECT_ROOT."/MVC/controller/forumCatagoriesController.php");
include(PROJECT_ROOT."/MVC/controller/forumPostController.php");
include(PROJECT_ROOT."/MVC/controller/forumThreadController.php");
include(PROJECT_ROOT."/MVC/controller/itemController.php");
include(PROJECT_ROOT."/MVC/controller/lockController.php");
include(PROJECT_ROOT."/MVC/controller/mapController.php");
include(PROJECT_ROOT."/MVC/controller/nameGeneratorController.php");
include(PROJECT_ROOT."/MVC/controller/partyController.php");
include(PROJECT_ROOT."/MVC/controller/privateMessagesController.php");
include(PROJECT_ROOT."/MVC/controller/profileController.php");
include(PROJECT_ROOT."/MVC/controller/profileImagesController.php");
include(PROJECT_ROOT."/MVC/controller/recipeController.php");
include(PROJECT_ROOT."/MVC/controller/shrineController.php");
include(PROJECT_ROOT."/MVC/controller/statusesController.php");
include(PROJECT_ROOT."/MVC/controller/storageController.php");
include(PROJECT_ROOT."/MVC/controller/zoneController.php");

//COMBINED CONTROLLER CLASSES
include(PROJECT_ROOT . "/MVC/overviewController/buildingItemController.php");
include(PROJECT_ROOT . "/MVC/overviewController/dayEndingFunctions.php");
include(PROJECT_ROOT . "/MVC/overviewController/HUDController.php");
include(PROJECT_ROOT . "/MVC/overviewController/mapPlayerController.php");
include(PROJECT_ROOT . "/MVC/overviewController/newMapJoinController.php");
include(PROJECT_ROOT . "/MVC/overviewController/partyZonePlayerController.php");
include(PROJECT_ROOT . "/MVC/overviewController/playerMapZoneController.php");

//VIEW CLASSES