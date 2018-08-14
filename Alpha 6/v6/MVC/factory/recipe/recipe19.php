<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe19 extends recipe
{
    function __construct()
    {
        $this->recipeID = 19;
        $this->description = "Make fish stew";
        $this->requiredItems = null;
        $this->requiredBuildings = 15;
        $this->consumedItems = array(27,13,19);
        $this->generatedItems = array(24,27);
        $this->recipeComment = "Gradually you boil the fish over the stove and watch as it gradually thaws. As the meat falls apart you're left with a bowl of bones and skin. It looks more nutritious than the frozen fish though.";
        $this->recipeImage = "testImage";
    }
}