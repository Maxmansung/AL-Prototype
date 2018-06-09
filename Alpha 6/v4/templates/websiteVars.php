<?php
$site = 2;


switch ($site){
    case 1:
        //USE THIS TO GET THE DIRECT WEBSITE LOCATION (TEST SITE)
        //define('PROJECT_ROOT', "/home/u509281701/public_html");
        define('COMPOSER_ROOT', "/home/u509281701");
        define('SITE_ADDRESS','.arcticlandstest.xyz');
        break;
    case 2:
        //USE THIS TO GET THE DIRECT WEBSITE LOCATION (MAIN SITE)
        //define('PROJECT_ROOT', "/home/u693200004/public_html");
        define('COMPOSER_ROOT', "/home/u693200004");
        define('SITE_ADDRESS','.arctic-lands.com');
        break;
    default:
        //USE THIS TO CODE ON PHPSTORM
        define('PROJECT_ROOT', $_SERVER['DOCUMENT_ROOT']);
        define('COMPOSER_ROOT', "/home/u509281701");
        define('SITE_ADDRESS','.arctic-lands.com');
        break;
}