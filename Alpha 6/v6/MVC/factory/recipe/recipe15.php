<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe15 extends recipe
{
    function __construct()
    {
        $this->recipeID = 15;
        $this->description = "Create frostbite heal";
        $this->requiredItems = null;
        $this->requiredBuildings = 21;
        $this->consumedItems = array(35,25,39);
        $this->generatedItems = array(31);
        $this->recipeComment = "With some analgesia, a bit of magic and the lost limb you might be able to regain some movement!";
        $this->recipeImage = "testImage";
    }
}