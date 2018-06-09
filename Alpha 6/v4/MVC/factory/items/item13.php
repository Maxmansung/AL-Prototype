<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item13 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 13;
        $this->identity = "";
        $this->icon = "";
        $this->description = "";
        $this->itemType = 0;
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