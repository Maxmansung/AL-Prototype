<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item20 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 20;
        $this->identity = "Moss";
        $this->icon = "mossRock";
        $this->description = "There's a little moss on this rock, maybe you could use it to insulate yourself";
        $this->itemType = 5;
        $this->usable = 0;
        $this->survivalBonus = 1;
        $this->statusImpact = 1;
        $this->givesRecipe = array(8);
    }
    function consumeItem()
    {
        return false;

    }
}