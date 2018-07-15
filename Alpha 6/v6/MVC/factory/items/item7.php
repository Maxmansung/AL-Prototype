<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item7 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 7;
        $this->identity = "Small animal";
        $this->icon = "smallAnimal";
        $this->description = "Keeps you warm but could also be butchered into something useful";
        $this->itemType = 3;
        $this->usable = false;
        $this->survivalBonus = 1;
        $this->statusImpact = 1;
        $this->givesRecipe = array(3);
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item7)");
    }
}