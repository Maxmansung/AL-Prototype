<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item30 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 30;
        $this->identity = "Wool";
        $this->icon = "wool";
        $this->description = "It's so fluffy and warm (and only mildly bloodstained), I wonder what you could make from it.";
        $this->itemType = 5;
        $this->usable = false;
        $this->survivalBonus = 3;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
        $this->dayEndChanges = false;
    }

    public function consumeItem()
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item30)");
    }
}