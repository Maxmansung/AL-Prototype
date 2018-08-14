<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe10 extends recipe
{
    function __construct()
    {
        $this->recipeID = 10;
        $this->description = "Mix cement";
        $this->requiredItems = null;
        $this->requiredBuildings = 20;
        $this->consumedItems = array(5,13,36);
        $this->generatedItems = array(37);
        $this->recipeComment = "It takes a lot of mixing and testing but eventually you've managed to create something resembling cement";
        $this->recipeImage = "testImage";
    }
}