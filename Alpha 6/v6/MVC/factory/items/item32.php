<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item32 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 32;
        $this->identity = "Crystals";
        $this->icon = "crystals";
        $this->description = "They're so shiney! It even looks like the light glowing from them!";
        $this->itemType = 4;
        $this->usable = false;
        $this->survivalBonus = 1;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item32)");
    }
}