<?php
define('PROJECT_ROOT', "/home/u693200004/public_html");
define('COMPOSER_ROOT', "/home/u693200004");
define('SITE_ADDRESS','.arctic-lands.com');
require_once(PROJECT_ROOT . "/MVC/filesInclude.php");
//FIRST THE GAME IS RETURNED TO DAY MODE TO BEGIN PLAY AGAIN
$nightfall = new websiteData("nightfall");
$nightfall->setResponse(0);
$nightfall->updateVariable();