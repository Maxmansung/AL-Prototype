<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe4 extends recipe
{
    function __construct()
    {
        $this->recipeID = 4;
        $this->description = "Create a torch";
        $this->requiredItems = 21;
        $this->requiredBuildings = null;
        $this->consumedItems = array(1,6);
        $this->generatedItems = array(3);
        $this->recipeComment = "With a huge swing you smashed the flint and metal together, showering the stick in shards of flint and sparks. One catches and with a little care the entire stick is alight";
        $this->recipeImage = "torch";
    }
}