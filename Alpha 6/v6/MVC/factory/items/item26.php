<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item26 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 26;
        $this->identity = "Metal Lump";
        $this->icon = "metal";
        $this->description = "This shining lump feels hard and cold to the touch, impressively someone must have melted it from the ground around.";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item26)");
    }
}