<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item2 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 2;
        $this->identity = "Snow";
        $this->icon = "snow";
        $this->description = "Mostly used for building, be careful with this around fires";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = -1;
        $this->statusImpact = 1;
        $this->givesRecipe = array(2);
    }
    function consumeItem()
    {
        return false;

    }

}