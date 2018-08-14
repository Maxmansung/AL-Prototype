<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item11 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 11;
        $this->identity = "Stone";
        $this->icon = "rock";
        $this->description = "A building material, good for stacking one on top of another";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array(16);
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item11)");
    }
}