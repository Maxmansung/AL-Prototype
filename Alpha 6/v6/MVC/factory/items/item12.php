<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item12 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 12;
        $this->identity = "Leaves";
        $this->icon = "leaves";
        $this->description = "Maybe you could scrunch these up and stick them down your rags to add a little insulation";
        $this->itemType = 5;
        $this->usable = false;
        $this->survivalBonus = 1;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item12)");
    }
}