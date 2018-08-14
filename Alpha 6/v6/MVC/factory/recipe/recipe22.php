<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe22 extends recipe
{
    function __construct()
    {
        $this->recipeID = 22;
        $this->description = "Distill toad";
        $this->requiredItems = null;
        $this->requiredBuildings = 20;
        $this->consumedItems = array(23,13);
        $this->generatedItems = array(25);
        $this->recipeComment = "You boil the toad carefully, then reduce the liquid and boil again until eventually you're left with a powdery substance. Who knows what this might do...";
        $this->recipeImage = "testImage";
    }
}