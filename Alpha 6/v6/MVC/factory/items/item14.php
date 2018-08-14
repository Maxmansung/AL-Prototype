<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item14 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 14;
        $this->identity = "Charcoal";
        $this->icon = "charcoal";
        $this->description = "This will burn much hotter and brighter than wood";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 0;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item14)");
    }
}