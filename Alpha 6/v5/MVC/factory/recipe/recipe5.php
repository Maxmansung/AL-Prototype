<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe5 extends recipe
{
    function __construct()
    {
        $this->recipeID = 5;
        $this->description = "Skin an Animal";
        $this->requiredItems = null;
        $this->requiredBuildings = 10;
        $this->consumedItems = array(7);
        $this->generatedItems = array(8);
        $this->recipeComment = "With a little care and consideration you manage to peal the skin from the poor creature. The meat and bones are destroyed in the process though.";
        $this->recipeImage = "testImage";
    }
}