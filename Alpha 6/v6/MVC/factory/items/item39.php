<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item39 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 39;
        $this->identity = "Rune";
        $this->icon = "rune";
        $this->description = "Be careful with this thing, you're playing with powers beyond your control now";
        $this->itemType = 4;
        $this->usable = false;
        $this->survivalBonus = -3;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item39)");
    }
}