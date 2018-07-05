<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/controller/chatlogController.php");
require_once(PROJECT_ROOT."/MVC/controller/chatlogMovementController.php");
require_once(PROJECT_ROOT."/MVC/controller/chatlogStorageController.php");
require_once(PROJECT_ROOT."/MVC/controller/chatlogGroupController.php");
require_once(PROJECT_ROOT."/MVC/controller/chatlogPersonalController.php");
require_once(PROJECT_ROOT."/MVC/controller/chatlogWorldController.php");
require_once(PROJECT_ROOT."/MVC/controller/chatlogZoneController.php");
class chatlogAllController
{

    //////////////VIEW FUNCTIONS//////////////


    //This returns all of the logs that relate to the zone
    public static function getAllLogs($avatar,$map,$party,$zone,$day){
        if ($day === "current" || $day == $map->getCurrentDay()){
            $day = intval($map->getCurrentDay());
        }
        $protected = buildingItemController::lockChecker($avatar,$zone,"",false);
        if ($day == $map->getCurrentDay()) {
            $movementLog = chatlogMovementController::getAllMovementLogs($avatar->getZoneID(), $party->getPlayersKnown(), $map->getCurrentDay(), $avatar->getAvatarID());
        } else {
            $movementLog = [];
        }
        if ($protected === true) {
            $storageLog = chatlogStorageController::getAllStorageLogs($avatar->getZoneID(), $party->getPlayersKnown(), $day, $avatar->getAvatarID());
        } else {
            $storageLog = [];
        }
        $groupLog = chatlogGroupController::getAllGroupLogs($avatar->getPartyID(),$day,$party->getPlayersKnown());
        $zoneLogs = chatlogZoneController::getAllZoneLogs($avatar->getZoneID(),$day,$avatar->getAvatarID());
        $personalLogs = chatlogPersonalController::getAllPersonalLogs($day,$avatar->getAvatarID());
        $worldLogs = chatlogWorldController::getAllWorldLogs($map->getMapID(),$day);
        $totalArray = [];
        foreach ($movementLog as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $totalArray)) {
                $log["messageTimestamp"] += 1;
            }
            $totalArray[$log["messageTimestamp"]] = $log;
        }
        foreach ($storageLog as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $totalArray)) {
                $log["messageTimestamp"] += 1;
            }
            $totalArray[$log["messageTimestamp"]] = $log;
        }
        foreach ($groupLog as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $totalArray)) {
                $log["messageTimestamp"] += 1;
            }
            $totalArray[$log["messageTimestamp"]] = $log;
        }
        foreach ($zoneLogs as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $totalArray)) {
                $log["messageTimestamp"] += 1;
            }
            $totalArray[$log["messageTimestamp"]] = $log;
        }
        foreach ($personalLogs as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $totalArray)) {
                $log["messageTimestamp"] += 1;
            }
            $totalArray[$log["messageTimestamp"]] = $log;
        }
        foreach ($worldLogs as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $totalArray)) {
                $log["messageTimestamp"] += 1;
            }
            $totalArray[$log["messageTimestamp"]] = $log;
        }
        return $totalArray;
    }

}