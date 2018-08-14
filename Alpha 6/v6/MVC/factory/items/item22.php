<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item22 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 22;
        $this->identity = "Tar";
        $this->icon = "tar";
        $this->description = "Eugh, this black stuff is sticking to everything!";
        $this->itemType = 4;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item22)");
    }
}