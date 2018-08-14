<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe17 extends recipe
{
    function __construct()
    {
        $this->recipeID = 17;
        $this->description = "Distill mushrooms";
        $this->requiredItems = null;
        $this->requiredBuildings = 20;
        $this->consumedItems = array(18,13);
        $this->generatedItems = array(25);
        $this->recipeComment = "You boil the mushrooms carefully, then reduce the liquid and boil again until eventually you're left with a powdery substance. Who knows what this might do...";
        $this->recipeImage = "testImage";
    }
}