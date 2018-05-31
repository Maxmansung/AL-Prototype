<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));

//BASE BIOME CLASS
include_once(PROJECT_ROOT."/MVC/factory/biomes/biomeType.php");

//ALL BIOME CLASSES
include_once(PROJECT_ROOT."/MVC/factory/biomes/biome1.php");
include_once(PROJECT_ROOT."/MVC/factory/biomes/biome2.php");
include_once(PROJECT_ROOT."/MVC/factory/biomes/biome3.php");
include_once(PROJECT_ROOT."/MVC/factory/biomes/biome4.php");
include_once(PROJECT_ROOT."/MVC/factory/biomes/biome5.php");
include_once(PROJECT_ROOT."/MVC/factory/biomes/biome6.php");
include_once(PROJECT_ROOT."/MVC/factory/biomes/biome100.php");

