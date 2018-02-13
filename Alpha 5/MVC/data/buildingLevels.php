<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
/////////THIS HOLDS THE UPGRADE LEVELS FOR THE GAME IN A SINGLE CLASS
class buildingLevels
{

    //THIS DEFINES THE UPGRADE COST FOR EACH LEVEL OF THE STORAGE BUILDING
    public static function storageUpgradeCost($level){
        switch ($level){
            case 1:
            case 2:
            case 3:
                return array("I0002"=>2,"I0001"=>1);
                break;
            case 4:
            case 5:
                return array("I0001"=>4,"I0005"=>2);
            default:
                return array("ERROR"=>"X");
                break;
        }
    }

    //THIS DEFINES THE UPGRADE COST FOR EACH LEVEL OF THE BACKPACK OPTION
    public static function backpackUpgradeCost($level){
        switch ($level){
            case 3:
                return array("I0012"=>1);
                break;
            case 4:
                return array("I0008"=>1);
                break;
            case 5:
                return array("I0008"=>1,"I0012"=>1);
                break;
            case 6:
            case 7:
                return array("I0008"=>3);
            default:
                return array("ERROR"=>"X");
                break;
        }
    }

    //THIS DEFINES THE UPGRADE COST FOR EACH LEVEL OF THE SLEEPING BAG OPTION
    public static function sleepingBagUpgradeCost($level){
        switch ($level){
            case 1:
                return array("I0012"=>1);
                break;
            case 2:
                return array("I0012"=>2);
                break;
            case 3:
                return array("I0012"=>1,"I0010"=>1);
                break;
            case 4:
                return array("I0012"=>3);
                break;
            case 5:
                return array("I0008"=>1);
            case 6:
                return array("I0012"=>1,"I0008"=>1);
            case 7:
                return array("I0008"=>2);
            default:
                return array("ERROR"=>"X");
                break;
        }
    }

    //THIS DEFINES THE TEMPERATURE BONUS GAINED FROM EACH LEVEL OF THE SLEEPING BAG
    public static function sleepingBagLevelBonus($level){
        switch ($level){
            case 2:
                return 2;
                break;
            case 3:
                return 4;
                break;
            case 4:
                return 7;
                break;
            case 5:
                return 11;
                break;
            case 6:
                return 16;
                break;
            case 7:
                return 22;
                break;
            case 8:
                return 30;
                break;
            default:
                return 0;
                break;
        }
    }

    //THIS DEFINES THE STAMINA COST OF EACH RESEARCH LEVEL UPGRADE
    public static function researchStaminaLevels($level){
        switch ($level){
            case 1:
                return 8;
                break;
            case 2:
            case 3:
                return 6;
                break;
            case 4:
            case 5:
                return 5;
            default:
                return 4;
                break;
        }
    }

    //THIS IS THE STARTING ITEMS FOR THE PLAYER
    public static function playerStartingItems(){
        return array("I0006","I0011");
    }


    //THIS RETURN THE INCREASE IN NIGHT TEMPERATURE EACH DAY
    public static function increaseNightTemperature($dayNumber){
        //Creates a sigmoid curve
        $temp = floor(atan(($dayNumber-6)/4)*40+40);
        //Creates a plateu curve
        //$changeMax = floor(($dayNumber*15) / ($dayNumber+4));
        return $temp;
    }

    //THIS RETURNS THE CODE TO WORK OUT THE TOTAL TEMPERATURE MODIFIER
    public static function getTotalSurviveTemp($avatarID){
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $biome = new biomeTypeController($zone->getBiomeType());
        $party = new partyController($avatar->getPartyID());
        $buildingsIncrease = self::buildingsTempIncrease($avatar->getAvatarID());
        if (count($party->getMembers()) === 0){
            $partyBonus = 0;
        } else {
            $partyBonus = floor($party->getTempBonus() / count($party->getMembers()));
        }
        $itemsSurvival = avatarController::getItemBonuses($avatar->getMapID(),$avatar->getAvatarID());
        $modifierBonus = buildingLevels::sleepingBagLevelBonus($avatar->getTempModLevel());
        $totalSurvival = $biome->getTemperatureMod()+$zone->getZoneSurvivableTemperatureModifier()+$avatar->getAvatarSurvivableTemp()+$modifierBonus+$itemsSurvival+$buildingsIncrease+$partyBonus;
        return $totalSurvival;
    }

    //THIS RETURNS THE CODE TO WORK OUT THE TOTAL TEMPERATURE MODIFIER
    public static function getModifiedViewSurviveTemp($avatarID){
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $party = new partyController($avatar->getPartyID());
        $buildingsIncrease = self::buildingsTempIncrease($avatar->getAvatarID());
        if (count($party->getMembers()) === 0){
            $partyBonus = 0;
        } else {
            $partyBonus = floor($party->getTempBonus() / count($party->getMembers()));
        }
        $itemsSurvival = avatarController::getItemBonuses($avatar->getMapID(),$avatar->getAvatarID());
        $modifierBonus = buildingLevels::sleepingBagLevelBonus($avatar->getTempModLevel());
        $totalSurvival = $zone->getZoneSurvivableTemperatureModifier()+$avatar->getAvatarSurvivableTemp()+$modifierBonus+$itemsSurvival+$buildingsIncrease+$partyBonus;
        return $totalSurvival;
    }



    public static function buildingsTempIncrease($avatarID){
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        if ($zone->getControllingParty() != null){
            if ($zone->getControllingParty() == $avatar->getPartyID() || buildingController::getLockValue($zone->getZoneID()) == 0){
                $buildingsIncrease = buildingController::getZoneTempBonus($zone->getBuildings(),$avatar->getZoneID());
            } else {
                $buildingsIncrease = 0;
            }
        } else {
            $buildingsIncrease = buildingController::getZoneTempBonus($zone->getBuildings(),$avatar->getZoneID());
        }
        return $buildingsIncrease;
    }

    //THIS DEFINES THE STARTING ACHIEVEMENTS FOR PLAYERS
    public static function getStartingAchievements($gameType,$avatar){
        switch ($gameType){
            case "Main":
                $avatar->addAchievement("A001");
                break;
            default:
                break;
        }
    }

    public static function performShrineBonus($bonusType, $bonusCount, $avatar,$shrineID){
        switch ($bonusType){
            case "Temp":
                $party = new partyController($avatar->getPartyID());
                $party->setTempBonus($bonusCount);
                $party->uploadParty();
                chatlogGroupController::spiritBlessingGroup($avatar->getAvatarID(),$party->getPartyID(),$shrineID);
                break;
            case "Item":
                $item = new itemController("");
                $item->createNewItemByID($bonusCount,$avatar->getMapID(),$avatar->getAvatarID(),"backpack");
                $item->insertItem();
                $avatar->addInventoryItem($item->getItemID());
                chatlogPersonalController::shrineBonusItem($avatar->getAvatarID(),$shrineID);
                break;
            case "Research":
                $avatar->adjustResearchStatsStamina($bonusCount);
                break;
            case "Stamina":
                $avatar->useStamina(($bonusCount*-1));
                break;
            default:
                break;
        }
    }


    //THIS RETURNS DETAILS ABOUT THE SHRINES TO BE USED TO DISPLAY THE SHRINE
    public static function getShrineDetails($shrineArray){
        $tempArray = [];
        foreach ($shrineArray as $key=>$value){
            $shrine = shrineController::createBlankShrine($key);
            $tempArray[$key] = $shrine->returnVars();
            $tempArray[$key]["score"] = $value;
        }
        return $tempArray;
    }
}