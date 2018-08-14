<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item33 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 33;
        $this->identity = "Ore";
        $this->icon = "ore";
        $this->description = "This rock seems to have something mixed in with it. If only there was a way to extract it";
        $this->itemType = 4;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item33)");
    }
}