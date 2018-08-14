<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));

//CONTROLLER CLASS
include_once(PROJECT_ROOT."/MVC/factory/status/statuses.php");

//ALL STATUS CLASSES
include_once(PROJECT_ROOT."/MVC/factory/status/status1.php");
include_once(PROJECT_ROOT."/MVC/factory/status/status2.php");
include_once(PROJECT_ROOT."/MVC/factory/status/status3.php");
include_once(PROJECT_ROOT."/MVC/factory/status/status4.php");
include_once(PROJECT_ROOT."/MVC/factory/status/status5.php");
include_once(PROJECT_ROOT."/MVC/factory/status/status6.php");

//THE FIVE BASIC CONSUME TYPES
include_once(PROJECT_ROOT."/MVC/factory/status/response/responseController.php");
include_once(PROJECT_ROOT."/MVC/factory/status/response/responseDrug.php");
include_once(PROJECT_ROOT."/MVC/factory/status/response/responseFood.php");
include_once(PROJECT_ROOT."/MVC/factory/status/response/responseMedicine.php");
include_once(PROJECT_ROOT."/MVC/factory/status/response/responseSnack.php");
