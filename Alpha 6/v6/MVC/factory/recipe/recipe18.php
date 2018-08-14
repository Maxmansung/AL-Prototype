<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe18 extends recipe
{
    function __construct()
    {
        $this->recipeID = 18;
        $this->description = "Make meat stew";
        $this->requiredItems = null;
        $this->requiredBuildings = 15;
        $this->consumedItems = array(27,13,9);
        $this->generatedItems = array(24,27);
        $this->recipeComment = "Gradually you boil the meat over the stove, it turns from an off red colour to more of a grey. It may not look appealing but at least it seems pretty nutritious.";
        $this->recipeImage = "testImage";
    }
}