<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe11 extends recipe
{
    function __construct()
    {
        $this->recipeID = 11;
        $this->description = "Melt sand";
        $this->requiredItems = null;
        $this->requiredBuildings = 25;
        $this->consumedItems = array(36,14,14);
        $this->generatedItems = array(38);
        $this->recipeComment = "Watching the little pile of sand begin to glow is almost mesmerising. You pour it out onto the cold snow and watch it steams ino a charred lump of... glass?";
        $this->recipeImage = "testImage";
    }
}