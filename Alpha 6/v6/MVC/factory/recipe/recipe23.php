<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe23 extends recipe
{
    function __construct()
    {
        $this->recipeID = 23;
        $this->description = "Dismantle Corpse";
        $this->requiredItems = null;
        $this->requiredBuildings = 10;
        $this->consumedItems = array(29);
        $this->generatedItems = array(28,30);
        $this->recipeComment = "The corpse is disgusting, it's clearly been dead for weeks and none of the meat is edible at all. You manage to remove some wool from it's coat though and the tusks look like they could be useful.";
        $this->recipeImage = "testImage";
    }
}