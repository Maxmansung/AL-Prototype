<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item8 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 8;
        $this->identity = "Animal Skin";
        $this->icon = "fur";
        $this->description = "This looks warm, maybe it could help to improve your equipment";
        $this->itemType = 5;
        $this->usable = false;
        $this->survivalBonus = 2;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item8)");
    }
}