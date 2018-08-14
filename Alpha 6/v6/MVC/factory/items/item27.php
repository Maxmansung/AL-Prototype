<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item27 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 27;
        $this->identity = "Carved Bowl";
        $this->icon = "bowl";
        $this->description = "It's not great but there's enough of a curve to hold something inside now";
        $this->itemType = 3;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array(13,14);
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item27)");
    }
}