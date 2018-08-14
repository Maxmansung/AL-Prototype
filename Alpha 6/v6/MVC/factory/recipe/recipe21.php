<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe21 extends recipe
{
    function __construct()
    {
        $this->recipeID = 21;
        $this->description = "Smelt ore";
        $this->requiredItems = null;
        $this->requiredBuildings = 25;
        $this->consumedItems = array(33,14,14);
        $this->generatedItems = array(26);
        $this->recipeComment = "It takes a lot of blowing and heating to eventually get the rock to melt down, but it does. As you pour out the liquid onto a rock and watch it cool you realise that you've actually created a metal (although what kind of metal it is you have no idea...)";
        $this->recipeImage = "testImage";
    }
}