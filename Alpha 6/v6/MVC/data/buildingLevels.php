<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
/////////THIS HOLDS THE UPGRADE LEVELS FOR THE GAME IN A SINGLE CLASS
class buildingLevels
{

    public static function checkFavourGained($speed,$gameType){
        if ($speed === "full"){
            if ($gameType === 1){
                return true;
            }
            if ($gameType === 6){
                return "life";
            }
        }
        return false;
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


    //THIS RETURN THE INCREASE IN NIGHT TEMPERATURE EACH DAY
    public static function increaseNightTemperature($dayNumber){
        //Creates a sigmoid curve
        $temp = floor(atan(($dayNumber-6)/4)*40+40);
        //Creates a plateu curve
        //$changeMax = floor(($dayNumber*15) / ($dayNumber+4));
        return $temp;
    }

    //THIS RETURNS THE CODE TO WORK OUT THE TOTAL TEMPERATURE MODIFIER
    public static function getTotalSurviveTemp($avatar,$zone,$biome,$party,$adjusted){
        $buildingsIncrease = self::buildingsTempIncrease($avatar,$zone);
        if (count($party->getMembers()) === 0){
            $partyBonus = 0;
        } else {
            $partyBonus = floor($party->getTempBonus() / count($party->getMembers()));
        }
        $itemsSurvival = buildingLevels::getItemBonuses($avatar);
        $totalSurvival = $zone->getZoneSurvivableTemperatureModifier()+$avatar->getAvatarSurvivableTemp()+$itemsSurvival+$buildingsIncrease+$partyBonus;
        if ($adjusted === false){
            $totalSurvival += $biome->getTemperatureMod();
        }
        return $totalSurvival;
    }

    public static function buildingsTempIncrease($avatar, $zone){
        if ($zone->getControllingParty() != null){
            if ($zone->getControllingParty() == $avatar->getPartyID() || buildingController::getLockValue($zone->getZoneID()) == 0){
                $buildingsIncrease = buildingLevels::buildingsBonus($zone);
            } else {
                $buildingsIncrease = 0;
            }
        } else {
            $buildingsIncrease = buildingLevels::buildingsBonus($zone);
        }
        return $buildingsIncrease;
    }

    public static function totalNightTemp($map,$biome,$adjusted){
        if ($adjusted === false){
            return $map->getBaseNightTemperature();
        } else {
            $temp = $map->getBaseNightTemperature()-$biome->getTemperatureMod();
            return $temp;
        }
    }

    //THIS CALCULATES THE TOTAL BONUS FROM ALL OF THE BUILDINGS
    public static function buildingsBonus($zone){
        $total = 0;
        foreach ($zone->getBuildings() as $building){
            $name = "building".$building;
            $class = new $name();
            $total += $class->getTempBonus($zone);
        }
        return $total;
    }

    //THIS CALCULATES THE TOTAL TEMP BONUS FROM ALL THE ITEMS
    public static function getItemBonuses($avatar)
    {
        $bonus = 0;
        foreach ($avatar->getInventory() as $id){
            $name = "item".$id;
            $item = new $name();
            $bonus += $item->getSurvivalBonus();

        }
        return $bonus;
    }

    //THIS DEFINES THE STARTING ACHIEVEMENTS FOR PLAYERS
    public static function getStartingAchievements($gameType,$avatar){
        switch ($gameType){
            case 1:
                $avatar->addAchievement("A001");
                break;
            default:
                break;
        }
    }

    //THIS IS THE STARTING ITEMS FOR THE PLAYER
    public static function playerStartingItems(){
        return array(6,21);
    }
}