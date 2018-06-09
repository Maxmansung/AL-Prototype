<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item18 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 18;
        $this->identity = "Mushrooms";
        $this->icon = "mushrooms";
        $this->description = "You can never remember if it's the white with red spots or the red with white spots that's poisonous...";
        $this->itemType = 1;
        $this->usable = 1;
        $this->survivalBonus = 0;
        $this->statusImpact = 3;
        $this->edible = "Your eyesight fades away, and you remember that it was the red spo...";
        $this->inedible = "you still feel woozy since the last time, best to give it a rest.";
        $this->givesRecipe = array();
    }
    function consumeItem()
    {
        return true;

    }
}