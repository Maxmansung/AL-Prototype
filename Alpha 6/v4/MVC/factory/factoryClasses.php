<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));


//ALL FACTORY CLASS SHEETS INCLUDED HERE
include_once(PROJECT_ROOT."/MVC/factory/factoryClassArray.php");
include_once(PROJECT_ROOT."/MVC/factory/items/itemClasses.php");
include_once(PROJECT_ROOT."/MVC/factory/buildings/buildingClasses.php");
include_once(PROJECT_ROOT."/MVC/factory/shrines/shrineClasses.php");
include_once(PROJECT_ROOT."/MVC/factory/status/statusClasses.php");
include_once(PROJECT_ROOT."/MVC/factory/biomes/biomeClasses.php");
include_once(PROJECT_ROOT."/MVC/factory/deathType/deathClasses.php");
include_once(PROJECT_ROOT."/MVC/factory/equipment/equipmentClasses.php");
include_once(PROJECT_ROOT."/MVC/factory/recipe/recipeClasses.php");