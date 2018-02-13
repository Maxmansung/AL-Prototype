<?php

define('PROJECT_ROOT', "/home/u693200004/public_html");
define('COMPOSER_ROOT', "/home/u693200004");
define('SITE_ADDRESS','.arctic-lands.com');

require_once(PROJECT_ROOT . "/MVC/filesInclude.php");

//FIRST THE GAME IS TURNED TO THE NIGHTTIME MODE TO PREVENT PLAYERS PERFORMING ACTIONS
$nightfall = new websiteData("nightfall");
$nightfall->setResponse(1);
$nightfall->updateVariable();

//THIS FUNCTION ENDS THE DAY FOR EACH TOWN
$townList = mapController::getAllMaps24hr();
foreach ($townList as $town) {
    $map = new mapController($town);
    if (count($map->getAvatars()) >= $map->getMaxPlayerCount()) {

        dayEndingFunctions::mapDayEnds($map->getMapID());
    }
}