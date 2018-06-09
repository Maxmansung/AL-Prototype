<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item6 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 6;
        $this->identity = "Flint";
        $this->icon = "flint";
        $this->description = "These sharp stones are good for cutting meat and can even create a spark when scratched against metal";
        $this->itemType = 3;
        $this->usable = false;
        $this->survivalBonus = 0;
        $this->statusImpact = 1;
        $this->givesRecipe = array();
    }
    function consumeItem()
    {
        return false;

    }
}