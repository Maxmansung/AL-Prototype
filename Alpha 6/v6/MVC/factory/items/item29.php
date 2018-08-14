<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item29 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 29;
        $this->identity = "Rotting Corpse";
        $this->icon = "corpse";
        $this->description = "Eugh, the stench is unbearable. You wouldn't want to eat what's left of this things but maybe you can get something from it";
        $this->itemType = 3;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item29)");
    }
}