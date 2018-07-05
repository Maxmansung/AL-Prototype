<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe2 extends recipe
{
    function __construct()
    {
        $this->recipeID = 2;
        $this->description = "Make a snowman";
        $this->requiredItems = 2;
        $this->requiredBuildings = null;
        $this->consumedItems = array(2,2);
        $this->generatedItems = array(4);
        $this->recipeComment = "What fun it is, rolling those lumps of snow into a little image of the Great Snowman.";
        $this->recipeImage = "snowman";
    }
}