<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item4 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 4;
        $this->identity = "Snowman";
        $this->icon = "snowman";
        $this->description = "Awww.... its so warm and huggable";
        $this->itemType = 2;
        $this->usable = false;
        $this->survivalBonus = -2;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
    }
    function consumeItem()
    {
        return false;

    }
}