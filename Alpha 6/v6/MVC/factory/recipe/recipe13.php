<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe13 extends recipe
{
    function __construct()
    {
        $this->recipeID = 13;
        $this->description = "Melt ice";
        $this->requiredItems = 27;
        $this->requiredBuildings = null;
        $this->consumedItems = array(3,27,17);
        $this->generatedItems = array(27,13);
        $this->recipeComment = "As you heat the ice it gradually melts down until you're left with a puddle of water, it wont last long though";
        $this->recipeImage = "testImage";
    }
}