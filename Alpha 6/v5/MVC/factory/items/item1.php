<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class item1 extends item
{

    function __construct()
    {
        //THIS IS THE ITEM TYPE
        $this->itemTemplateID = 1;

        //THIS IS THE NAME OF THE ITEM AS SHOWN IN THE GAME
        $this->identity = "Small Stick";

        //THIS IS A NAME WITHOUT SPECIAL CHARACTERS THAT WILL BE THE IMAGE FILE NAME
        $this->icon = "stick";

        //THIS IS THE DESCRIPTION OF THE ITEM AS SHOWN IN THE GAME
        $this->description = "A stick can be lit on fire to make a torch or used to build buildings";

        //THIS IS THE CATEGORY OF ITEM (BOOSTERS, MATERIALS, HEAT ETC)
        $this->itemType = 2;

        //THIS DICTATES IF AN ITEM CAN BE CONSUMED OR USED IN SOME WAY (FOOD, BANDAGES ETC)
        $this->usable = false;

        //THIS IS THE BONUS TEMPERATURE GIVEN BY THE ITEM
        $this->survivalBonus = 0;

        //THIS IS USED TO QUICKLY CHECK THE IMPACT OF CONSUMING THIS ITEM WILL DO
        $this->statusImpact = 1;

        //THIS IS USED TO FIND ANY ASSOCIATED RECIPES
        $this->givesRecipe = array();

        //THIS IS USED TO DETECT IF CHANGES HAPPEN OVERNIGHT WITH THE ITEM
        $this->dayEndChanges = false;

    }

    //THIS WILL BE USED TO WORK OUT WHAT HAPPENS WHEN AN ITEM IS CONSUMED, EVERY ITEM WILL HAVE THIS FUNCTION BUT IT WILL ALWAYS RETURN FALSE UNLESS THAT ITEM CAN BE CONSUMED
    function consumeItem($avatar)
    {
        return array("ERROR"=>"This item cannot be consumed, please bug report this (Item1)");
    }

}