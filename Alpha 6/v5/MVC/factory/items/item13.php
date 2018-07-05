<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item13 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 13;
        $this->identity = "";
        $this->icon = "";
        $this->description = "";
        $this->itemType = 0;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item13)");
    }
}