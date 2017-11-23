<?php
/////////THIS HOLDS THE UPGRADE LEVELS FOR THE GAME IN A SINGLE CLASS
///
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

    //THIS DEFINES THE UPGRADE COST FOR EACH LEVEL OF THE SLEEPING BAG OPTION
    public static function sleepingBagUpgradeCost($level){
        switch ($level){
            case 1:
                return array("I0012"=>1);
                break;
            case 2:
                return array("I0008"=>1);
                break;
            case 3:
                return array("I0008"=>1,"I0012"=>1);
                break;
            case 4:
            case 5:
                return array("I0008"=>3);
            default:
                return array("ERROR"=>"X");
                break;
        }
    }

    //THIS DEFINES THE STAMINA COST OF EACH RESEARCH LEVEL UPGRADE
    public static function researchStaminaLevels($level){
        switch ($level){
            case 1:
                return 10;
                break;
            case 2:
            case 3:
                return 15;
                break;
            case 4:
            case 5:
                return 20;
            default:
                return array("ERROR"=>"X");
                break;
        }
    }

    //THIS DEFINES THE TEMPERATURE BONUS GAINED FROM EACH LEVEL OF THE SLEEPING BAG
    public static function sleepingBagLevelBonus($level){
        switch ($level){
            case 1:
                return 2;
                break;
            case 2:
                return 4;
                break;
            case 3:
                return 8;
                break;
            case 4:
                return 12;
                break;
            case 5:
                return 20;
                break;
            default:
                return 0;
                break;
        }
    }

    //THIS IS THE STARTING ITEMS FOR THE PLAYER
    public static function playerStartingItems(){
        return array("I0006","I0011");
    }

    //THESE ARE THE BUILDINGS THAT PLAYERS START THE GAME KNOWING
    public static function startingBuildings(){
        return array("B0001","B0002","B0003","B0004","B0005");
    }

    //THIS RETURNS THE CODE TO WORK OUT THE TOTAL TEMPERATURE MODIFIER
    public static function getTotalSurviveTemp($avatarID){
        $avatar = new avatarController($avatarID);
        $zone = new zoneController($avatar->getZoneID());
        $biome = new biomeTypeController($zone->getBiomeType());
        if ($zone->getControllingParty() != "empty"){
            if ($zone->getControllingParty() == $avatar->getPartyID() || buildingController::getLockValue($zone->getZoneID()) == 0){
                $buildingsIncrease = buildingController::getZoneTempBonus($zone->getBuildings(),$avatar->getZoneID());
            } else {
                $buildingsIncrease = 0;
            }
        } else {
            $buildingsIncrease = buildingController::getZoneTempBonus($zone->getBuildings(),$avatar->getZoneID());
        }
        $itemsSurvival = avatarController::getItemBonuses($avatar->getInventory());
        $modifierBonus = buildingLevels::sleepingBagLevelBonus($avatar->getTempModLevel());
        $totalSurvival = $biome->getTemperatureMod()+$zone->getZoneSurvivableTemperatureModifier()+$avatar->getAvatarSurvivableTemp()+$modifierBonus+$itemsSurvival+$buildingsIncrease;
        return $totalSurvival;

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
}