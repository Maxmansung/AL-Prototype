<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item21 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 21;
        $this->identity = "Padlock";
        $this->icon = "lock";
        $this->description = "This rare item is a gift from the gods, use it wisely";
        $this->itemType = 3;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array(4);
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item21)");
    }

}