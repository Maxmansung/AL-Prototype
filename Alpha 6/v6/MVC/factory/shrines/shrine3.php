<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrine3 extends shrine
{
    public function __construct()
    {
        $this->shrineID = 3;
        $this->shrineName = "Dunia's Shadow";
        $this->description = "The remains of the great goddess Dunia are still worshipped by some after her death in the hopes of saving the world";
        $this->shrineIcon = "death_shrine";
        $this->worshipCost = ["Item"=>21];
        $this->worshipDescription = "Sacrifice a lock";
        $this->shrineBonus = ["SPECIAL"=>true];
        $this->blessingMessage = "The followers of Dunia have been imbued with renewed strength";
        $this->createShrineType(3);
        $this->shrineAlertMessage = "<b>Dunia's Shadow</b> has smiled upon the world today, a random zone has been replenished for each person on the map";
        $this->shrineAlertTitle = "Life God's Champion";
    }

    public function giveAvatarBonus(){
        return array();
    }

    public function specificUpgrade($map)
    {
        $zones = zoneController::getAllZones($map->getMapID(),true);
        $count = round($map->getEdgeSize()/4);
        $allowedBiomes = biomeType::getLandBiomes();
        for ($x=0;$x<$count;$x++){
            $counter = 0;
            $checker = false;
            while ($checker === false){
                $id = array_rand($zones,1);
                $tempZone = $zones[$id];
                if (in_array($tempZone->getBiomeType(),$allowedBiomes)){
                    if($tempZone->getControllingParty() == null) {
                        $checker = true;
                        $tempZone->setBiomeType(11);
                        $tempZone->resetFindingChances();
                        $tempZone->updateZone();
                    }
                }
                $counter++;
                if ($counter >20){
                    $checker = true;
                }
            }
        }
        $checker = false;
        $allowedBiomes = biomeType::getWaterBiomes();
        foreach ($zones as $zone){
            if ($checker === false){
                if (in_array($zone->getBiomeType(),$allowedBiomes)){
                    if($zone->getControllingParty() == null){
                        $checker = true;
                        $zone->setBiomeType(12);
                        $zone->resetFindingChances();
                        $zone->updateZone();
                    }
                }
            }
        }
    }

}