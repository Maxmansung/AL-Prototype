<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogMovementController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogStorageController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogFirepitController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogGroupController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogPersonalController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/zoneController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/buildingController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/HUDController.php");
class chatlogAllController
{

    //////////////VIEW FUNCTIONS//////////////


    //This returns all of the logs that relate to the zone
    public static function getAllLogs($avatarID,$day){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        if ($day === "current" || $day == $map->getCurrentDay()){
            $day = intval($map->getCurrentDay());
            $nightTemperature = $map->getBaseNightTemperature();
            $HUD = HUDController::getHUDStats($avatarID);
            $personalTemperature = $HUD->getCalcSurvTemp();
        } else {
            $nightTemperature = $map->getSingleTemperatureRecord($day);
            $personalTemperature = $avatar->getSingleAvatarTempRecord($day);
        }
        $party = new partyController($avatar->getPartyID());
        $zone = new zoneController($avatar->getZoneID());
        $lockValue = buildingController::getLockValue($zone->getZoneID());
        //This section ensures that players can not see things that occur in zones not owned by them
        if ($zone->getControllingParty() != "empty") {
            if ($lockValue < 1 || $zone->getControllingParty() == $avatar->getPartyID()){
                $protected = false;
            } else {
                $protected = true;
            }
        } else {
            $protected = false;
        }
        if ($day == $map->getCurrentDay()) {
            $movementLog = chatlogMovementController::getAllMovementLogs($avatar->getZoneID(), $party->getPlayersKnown(), $map->getCurrentDay(), $avatar->getAvatarID());
        } else {
            $movementLog = [];
        }
        if ($protected === false) {
            $firepitLog = chatlogFirepitController::getAllFirepitLogs($avatar->getZoneID(), $party->getPlayersKnown(), $day, $avatar->getAvatarID());
            $storageLog = chatlogStorageController::getAllStorageLogs($avatar->getZoneID(), $party->getPlayersKnown(), $day, $avatar->getAvatarID());
        } else {
            $firepitLog = [];
            $storageLog = [];
        }
        $groupLog = chatlogGroupController::getAllGroupLogs($avatar->getPartyID(),$day,$party->getPlayersKnown());
        $zoneLogs = chatlogZoneController::getAllZoneLogs($avatar->getZoneID(),$day,$avatar->getAvatarID());
        $personalLogs = chatlogPersonalController::getAllPersonalLogs($day,$avatar->getAvatarID());
        $totalArray = [];
        foreach ($movementLog as $key=>$log) {
            while (key_exists($log["messageTimestamp"], $totalArray)) {
                $log["messageTimestamp"] += 1;
            }
            $totalArray[$log["messageTimestamp"]] = $log;
        }
        foreach ($firepitLog as $key=>$log) {
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
        return array("logs" => $totalArray,"day"=>$day,"personalTemp"=>$personalTemperature,"nightTemp"=>$nightTemperature,"currentDay"=>$map->getCurrentDay());
    }

}