<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));

//THE CONTROLLER CLASS
include_once(PROJECT_ROOT."/MVC/factory/deathType/deathCause.php");

//ALL DEATH CLASSES
include_once(PROJECT_ROOT."/MVC/factory/deathType/death1.php");
include_once(PROJECT_ROOT."/MVC/factory/deathType/death2.php");
include_once(PROJECT_ROOT."/MVC/factory/deathType/death3.php");
include_once(PROJECT_ROOT."/MVC/factory/deathType/death4.php");
