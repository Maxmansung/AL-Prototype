<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe14 extends recipe
{
    function __construct()
    {
        $this->recipeID = 14;
        $this->description = "Melt snow";
        $this->requiredItems = 27;
        $this->requiredBuildings = null;
        $this->consumedItems = array(3,27,2);
        $this->generatedItems = array(27,13);
        $this->recipeComment = "As you heat the snow it gradually melts down until you're left with a puddle of water, it wont last long though";
        $this->recipeImage = "testImage";
    }
}