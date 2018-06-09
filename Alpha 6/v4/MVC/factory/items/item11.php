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
        $this->usable = 0;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
    }
    function consumeItem()
    {
        return false;

    }
}