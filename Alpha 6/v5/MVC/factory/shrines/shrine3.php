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
        $this->shrineBonus = ["ZONES"=>10];
        $this->blessingMessage = "The followers of Dunia have been imbued with renewed strength";
        $this->createShrineType(3);
        $this->shrineAlertMessage = "<b>Dunia's Shadow</b> has smiled upon the world today, a random zone has been replenished for each person on the map";
        $this->shrineAlertTitle = "Life God's Champion";
    }

    public function giveAvatarBonus(){
        return array();
    }

}