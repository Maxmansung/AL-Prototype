<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class HUDController
{
    //These are the cheat functions for the game
    private static $cheatsActive = true;


    public static function changeReady($profile){
        $avatar = new avatarController($profile->getAvatar());
        $map = new mapController($avatar->getMapID());
        $avatar->toggleReady("ready");
        $avatar->updateAvatar();
        if ($map->getDayDuration() === "check"){
            $counter = 0;
            foreach ($map->getAvatars() as $avatarTemp){
                $single = new avatarController($avatarTemp);
                if ($single->getReady() === 1 || $single->getReady() === "dead"){
                    $counter++;
                }
            }
            if ($counter >= $map->getMaxPlayerCount()) {
                HUDController::dayEndingCheck($map,"normal");
                //An ALERT is made to mark the day ending
                return array("ALERT" => 6,"DATA"=>"");
            } else {
                return array("SUCCESS" => true);
            }
        }
        return array("ERROR"=>"This has been disabled on real time maps");
    }

    public static function adminDayEnding($profile){
        $profile->getProfileAccess();
        if ($profile->getAccessEditMap()===1){
            //HUDController::dayEndingCheck($profile->getAvatar(),"admin");
            return array("ERROR" => 29);
        } else {
            $response = array("ERROR"=>28);
        }
        return $response;
    }

    public static function dayEndingCheck($map,$type)
    {
        if (count($map->getAvatars()) >= $map->getMaxPlayerCount() || $type === "admin") {
            dayEndingFunctions::mapDayEnds($map);
        }
    }

    public static function getDayEndTime(){
        $currentTime = time();
        $nightTime = strtotime("today 10pm");
        if (($nightTime-$currentTime)<0){
            $nextTime = strtotime("tomorrow 10pm");
            return $nextTime-$currentTime;
        } else {
            return $nightTime-$currentTime;
        }
    }

    public static function refreshStamina($avatarID){
        if (HUDController::$cheatsActive === true) {
            $avatar = new avatarController($avatarID);
            $map = new mapController($avatar->getMapID());
            if ($map->getGameType() === 5) {
                $avatar->setStamina($avatar->getMaxStamina());
                $avatar->updateAvatar();
                return array("ERROR"=>57);
            } else {
                return array("ERROR"=>100);
            }
        } else {
            return array("ERROR"=>100);
        }
    }

    public static function playerDeathKilling($avatarID,$profile){
        $profile->getProfileAccess();
        if ($profile->getAccessEditMap()===1){
            $avatarIDClean = intval(preg_replace(data::$cleanPatterns['num'], '', $avatarID));
            $avatar = new avatarController($avatarIDClean);
            if ($avatar->getAvatarID() === $avatarIDClean) {
                dayEndingFunctions::playerDeath($avatar,3);
                $profilePlayer = new profileController($avatar->getProfileID());
                $profilePlayer->setAvatar(null);
                $profilePlayer->setGameStatus("death");
                $profilePlayer->uploadProfile();
                modTrackingController::createNewTrack(7,$profile->getProfileID(),$profilePlayer->getProfileID(),$avatar->getMapID(),"","");
                return array("ALERT"=>26,"DATA"=>$avatar->getProfileID());
            } else {
                return array("ERROR"=>"This avatar does not exist");
            }
        } else {
            return array("ERROR"=>28);
        }
    }

    public static function playerDeathButton($avatarID){
        $avatar = new avatarController($avatarID);
        $map = new mapController($avatar->getMapID());
        $profile = new profileController($avatar->getProfileID());
        $profile->getProfileAccess();
        if ($profile->getAccessEditMap()===1 || $map->getGameType() == "Test") {
            dayEndingFunctions::playerDeath($avatarID,3);
            $avatarCheck = new deathScreenController($avatar->getProfileID());
            if ($avatarCheck->getProfileID() != "") {
                return array("ERROR" => 55);
            } else {
                return array("ERROR" => "For some reason your avatar just wont die");
            }
        } else {
            return array("ERROR"=>"You dont have the power to do that");
        }
    }

    public static function resetStatuses($avatarID){
        if (HUDController::$cheatsActive === true) {
            $avatar = new avatarController($avatarID);
            $map = new mapController($avatar->getMapID());
            if ($map->getGameType() === 5) {
                $array = $avatar->getStatusArray();
                foreach ($array as $key=>$status){
                    $status = 0;
                    $array[$key] = $status;
                }
                $avatar->setStatusArray($array);
                $avatar->updateAvatar();
                return array("ERROR"=>69);
            } else {
                return array("ERROR"=>100);
            }
        } else {
            return array("ERROR"=>100);
        }
    }
}