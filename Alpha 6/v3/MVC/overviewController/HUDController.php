<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class HUDController
{
    //These are the cheat functions for the game
    private static $infiniteStamina = true;


    public static function changeReady($profile){
        $avatar = new avatarController($profile->getAvatar());
        $map = new mapController($avatar->getMapID());
        $avatar->toggleReady("ready");
        $avatar->updateAvatar();
        if ($map->getDayDuration() === "check"){
            $counter = 0;
            foreach ($map->getAvatars() as $avatarTemp){
                $single = new avatarController($avatarTemp);
                if ($single->getReady() === 1){
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
        if (HUDController::$infiniteStamina === true) {
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

    private static function calculateShrineBonuses($mapID){
        $highest = shrineController::highestScoreShrine($mapID);
        $map = new mapController($mapID);
        if ($highest === "ERROR"){
            //This means that no shrine has any tribute to it
        } elseif (is_array($highest)){
            //This means that 2 or more shrines have the same amount of tribute as the highest
            $parties = partyController::findAllParties($mapID);
            foreach ($highest as $shrine){
                self::giveShrineBonuses($shrine,$parties,$map);
            }
        } else {
            //This means a single shrine had the highest score
            $parties = partyController::findAllParties($mapID);
            self::giveShrineBonuses($highest,$parties,$map);
        }

    }

    private static function giveShrineBonuses($shrineID,$allParties,$map){
        $shrine = new shrineController($shrineID);
        chatlogWorldController::shrineBonusGained($shrine->getZoneID());
        foreach ($allParties as $single){
            $single->setTempBonus(0);
            $single->uploadParty();
            if (count($single->getMembers()) <= $shrine->getMaxParty()){
                if (count($single->getMembers()) >= $shrine->getMinParty()){
                    foreach ($single->getMembers() as $member){
                        $avatar = new avatarController($member);
                        $avatar->addShineScore($shrine->getShrineType(),$map->getCurrentDay());
                        buildingLevels::performShrineBonus($shrine->getShrineBonusType(),$shrine->getShrineBonusReward(),$avatar,$shrine->getShrineID());
                        $avatar->updateAvatar();
                    }
                }
            }
        }

    }

    public static function testShrineBonuses($mapID){
        self::calculateShrineBonuses($mapID);
    }
}