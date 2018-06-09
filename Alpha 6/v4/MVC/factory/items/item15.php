<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item15 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 15;
        $this->identity = "Nuts and Seeds";
        $this->icon = "seeds";
        $this->description = "They're pretty tough but with some effort you could get some nutrition perhaps?";
        $this->itemType = 1;
        $this->usable = 1;
        $this->survivalBonus = 0;
        $this->statusImpact = 5;
        $this->edible = "You bite into the hard shells and almost breaks your teeth, you cant tell if ate anything but shells";
        $this->inedible = "You couldn't bear to eat these... yet.";
        $this->givesRecipe = array();
    }
    function consumeItem()
    {
        return true;

    }
}