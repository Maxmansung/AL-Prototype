<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe3 extends recipe
{
    function __construct()
    {
        $this->recipeID = 3;
        $this->description = "Smash Animal";
        $this->requiredItems = 7;
        $this->requiredBuildings = null;
        $this->consumedItems = array(7,11);
        $this->generatedItems = array("OTHER");
        $this->recipeComment = "You bring the rock down hard on the small creature with a sickening \"Squeak!\". As you look down you can see that most of the poor thing has been pulverised into  a red stain, all that's left is a small pile of ";
        $this->recipeImage = "testImage";
    }
}