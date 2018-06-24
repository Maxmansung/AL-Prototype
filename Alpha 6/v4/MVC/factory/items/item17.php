<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item17 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 17;
        $this->identity = "Ice Block";
        $this->icon = "iceBlock";
        $this->description = "Looks like this block has been cut straight out of a lake, its a mystery why you would want to though";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = -3;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item17)");
    }
}