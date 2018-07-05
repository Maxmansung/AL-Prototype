<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe6 extends recipe
{
    function __construct()
    {
        $this->recipeID = 6;
        $this->description = "Butcher an Animal";
        $this->requiredItems = null;
        $this->requiredBuildings = 10;
        $this->consumedItems = array(7);
        $this->generatedItems = array(9);
        $this->recipeComment = "With a little care and consideration you manage to butcher some small steaks from the creature. The skin and bones are destroyed in the process though.";
        $this->recipeImage = "testImage";
    }
}