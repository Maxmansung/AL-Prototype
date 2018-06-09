<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item10 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 10;
        $this->identity = "Animal Bones";
        $this->icon = "boneMax";
        $this->description = "All that's left of a small creature, perhaps it could be made into something though";
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