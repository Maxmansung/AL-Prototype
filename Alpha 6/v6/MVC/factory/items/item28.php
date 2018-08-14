<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item28 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 28;
        $this->identity = "Tusks";
        $this->icon = "tusks";
        $this->description = "These old bones have a pretty sharp point to them. It's a good thing the animal they belong to isn't around any more";
        $this->itemType = 3;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array(20);
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item28)");
    }
}