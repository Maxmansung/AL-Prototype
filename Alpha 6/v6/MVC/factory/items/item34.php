<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item34 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 34;
        $this->identity = "Potash";
        $this->icon = "potash";
        $this->description = "It looks like dust but the plants around seem to love it!";
        $this->itemType = 4;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 5;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item34)");
    }
}