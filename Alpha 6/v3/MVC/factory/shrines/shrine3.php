<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrine3 extends shrine
{
    public function __construct()
    {
        $this->shrineName = "Dunia's Shadow";
        $this->description = "The remains of the great goddess Dunia are still worshipped by some after her death in the hopes of saving the world";
        $this->shrineIcon = "ice_shrine.png";
        $this->worshipCost = ["Item"=>"I0021"];
        $this->worshipDescription = "Sacrifice a lock";
        $this->shrineBonus = ["ZONES"=>10];
        $this->blessingMessage = "The followers of Dunia have been imbued with renewed strength";
        $this->createShrineType(3);
        $this->shrineAlertMessage = "<b>Dunia's Shadow</b> has smiled upon the world today, a random zone has been replenished for each person on the map";
    }

}