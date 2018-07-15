<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item3 extends item
{

    function __construct()
    {
        $this->itemTemplateID = 3;
        $this->identity = "Torch";
        $this->icon = "torch";
        $this->description = "A torch can keep you warm on cold nights, will become useless by morning though";
        $this->itemType = 5;
        $this->usable = false;
        $this->survivalBonus =3;
        $this->statusImpact = 1;
        $this->givesRecipe = array(1);
        $this->dayEndChanges = true;
    }

    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item3)");
    }

    public function dayEnding()
    {
        return array("ITEM"=>5);
    }

}