<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe1 extends recipe
{
    function __construct()
    {
        $this->recipeID = 1;
        $this->description = "Light a stick";
        $this->requiredItems = 3;
        $this->requiredBuildings = 1;
        $this->consumedItems = array(1);
        $this->generatedItems = array(3);
        $this->recipeComment = "Using one of the burning branches you light another torch";
        $this->recipeImage = "torch";
    }
}