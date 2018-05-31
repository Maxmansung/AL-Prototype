<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));

//SHRINE CONTROLLER CLASS
include_once(PROJECT_ROOT."/MVC/controller/shrineController.php");

//ALL SHRINE CLASSES
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrine1.php");
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrine2.php");
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrine3.php");

//THE THREE BASIC TYPES
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrineType/shrineType.php");
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrineType/shrineSolo.php");
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrineType/shrineTeam.php");
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrineType/shrineMap.php");
