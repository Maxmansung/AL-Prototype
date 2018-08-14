<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe20 extends recipe
{
    function __construct()
    {
        $this->recipeID = 20;
        $this->description = "Burn rune";
        $this->requiredItems = 28;
        $this->requiredBuildings = null;
        $this->consumedItems = array(28,32);
        $this->generatedItems = array(39);
        $this->recipeComment = "As you carve into the dead animals tusk with the crystals you feel them begin to warm in your hand. The markings left on the tusk glow and char before your eyes until eventually they burst into flames and the crystal crumbles to dust in your hand. It seems you're playing with powers you don't quite understand.";
        $this->recipeImage = "testImage";
    }
}