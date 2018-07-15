<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrine2 extends shrine
{
    public function __construct()
    {
        $this->shrineID = 2;
        $this->shrineName = "Old Xeadas";
        $this->description = "Xeadas favours the tribal, helping those who help themselves. He promotes both trade and war equally but punishes those who try to become too powerful and forget the tribal ways";
        $this->shrineIcon = "ice_shrine";
        $this->worshipCost = ["Item"=>1];
        $this->worshipDescription = "Burn a stick to worship";
        $this->shrineBonus = ["STAMINA"=>10];
        $this->blessingMessage = "The tribes of the world have pleased Old Xeadas enough for him to grant them a reprieve";
        $this->createShrineType(2);
        $this->shrineAlertMessage = "Your party are the chosen champions of <b>Old Xeadas</b>. You have all have been rewarded with: <b>10 stamina</b>";
        $this->shrineAlertTitle = "War God's Champion";
    }

    public function giveAvatarBonus(){
        return array("STAMINA"=>10);
    }



}