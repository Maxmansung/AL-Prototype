<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item36 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 36;
        $this->identity = "Sand";
        $this->icon = "sand";
        $this->description = "It's basically fine dirt, do you really want to be carrying around dirt?";
        $this->itemType = 1;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item36)");
    }
}