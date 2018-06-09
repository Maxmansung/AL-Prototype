<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item19 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 19;
        $this->identity = "Cold Fish";
        $this->icon = "fish";
        $this->description = "This is a pretty sorry looking fish, but maybe you could eat it";
        $this->itemType = 1;
        $this->usable = 1;
        $this->survivalBonus = -1;
        $this->statusImpact = 1;
        $this->edible = "It's like eating ice, but slimy.";
        $this->inedible = "You're not hungry enough.";
        $this->givesRecipe = array();
    }
    function consumeItem()
    {
        return true;

    }
}