<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe12 extends recipe
{
    function __construct()
    {
        $this->recipeID = 12;
        $this->description = "Distill ash";
        $this->requiredItems = 0;
        $this->requiredBuildings = 20;
        $this->consumedItems = array(5,13);
        $this->generatedItems = array(34);
        $this->recipeComment = "The black and gray ash takes a long time to filter through, but with a bit of work you've created 'Potash'!";
        $this->recipeImage = "testImage";
    }
}