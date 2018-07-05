<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe8 extends recipe
{
    function __construct()
    {
        $this->recipeID = 8;
        $this->description = "Mix a Salad";
        $this->requiredItems = 20;
        $this->requiredBuildings = null;
        $this->consumedItems = array(20,15);
        $this->generatedItems = array(16);
        $this->recipeComment = "You hum along as you mix together the moss and seed into something you could almost pretend is a salad";
        $this->recipeImage = "testImage";
    }
}