<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe7 extends recipe
{
    function __construct()
    {
        $this->recipeID = 7;
        $this->description = "De-bone an Animal";
        $this->requiredItems = null;
        $this->requiredBuildings = 10;
        $this->consumedItems = array(7);
        $this->generatedItems = array(10);
        $this->recipeComment = "You hack away at the skin and flesh off the poor animal in an attempt to reach the bones. By the end you have a beautifully clean bone... and a pile of mush.";
        $this->recipeImage = "testImage";
    }
}