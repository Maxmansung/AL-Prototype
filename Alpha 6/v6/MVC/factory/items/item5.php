<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item5 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 5;
        $this->identity = "Ash";
        $this->icon = "ash";
        $this->description = "This stick seems to have been burnt down to just a pile of ash";
        $this->itemType = 4;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item5)");
    }
}