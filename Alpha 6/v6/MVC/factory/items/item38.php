<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item38 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 38;
        $this->identity = "Glass";
        $this->icon = "glass";
        $this->description = "Ok, so it's not exactly a window. But this mess of molten sand could be useful";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item38)");
    }
}