<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item37 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 37;
        $this->identity = "Cement";
        $this->icon = "cement";
        $this->description = "You've made cement? I guess you wont be needing stones any more then";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item37)");
    }
}