<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));

//BUILDING CONTROLLER CLASSES
include_once(PROJECT_ROOT."/MVC/factory/buildings/buildingType/buildingType.php");
include_once(PROJECT_ROOT."/MVC/controller/buildingController.php");

//BUILDING TYPE CLASSES
include_once(PROJECT_ROOT."/MVC/factory/buildings/buildingType/buildingType1.php");
include_once(PROJECT_ROOT."/MVC/factory/buildings/buildingType/buildingType2.php");
include_once(PROJECT_ROOT."/MVC/factory/buildings/buildingType/buildingType3.php");

//BUILDING TEMPLATE CLASSES
include_once(PROJECT_ROOT."/MVC/factory/buildings/building1.php");
include_once(PROJECT_ROOT."/MVC/factory/buildings/building2.php");
include_once(PROJECT_ROOT."/MVC/factory/buildings/building3.php");