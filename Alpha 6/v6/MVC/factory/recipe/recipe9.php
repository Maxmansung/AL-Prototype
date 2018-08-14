<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe9 extends recipe
{
    function __construct()
    {
        $this->recipeID = 9;
        $this->description = "Cook charcoal";
        $this->requiredItems = null;
        $this->requiredBuildings = 16;
        $this->consumedItems = array(1,1,3);
        $this->generatedItems = array(14);
        $this->recipeComment = "It doesn't take long for the fire below to do it's work. Before you know it you've got fire!";
        $this->recipeImage = "testImage";
    }
}