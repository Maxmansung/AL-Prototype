<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class shrine1 extends shrine
{
    public function __construct()
    {
        $this->shrineName = "The Great Snowman";
        $this->description = "The Great Snowman watches over the lonely children of the world, helping those who are most in need... if they're willing to pay the price...";
        $this->shrineIcon = "ice_shrine.png";
        $this->worshipCost = ["Stamina"=>2];
        $this->worshipDescription = "Costs 2 stamina to worship";
        $this->shrineBonus = ["ITEM"=>"I0008"];
        $this->blessingMessage = "The Great Snowman has seen fit to bless the lonely souls across the world";
        $this->createShrineType(1);
        $this->shrineAlertMessage = "You are one of the chosen champions of <b>The Great Snowman</b> and have been rewarded with: <b>Animal Fur</b>";
    }

}