<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/recipe_Interface.php");
class recipe implements recipe_Interface
{

    protected $recipeID;
    protected $description;
    protected $requiredItems;
    protected $requiredBuildings;
    protected $consumedItems;
    protected $generatedItems;
    protected $recipeComment;
    protected $recipeImage;


    public function __toString()
    {
        $output = $this->recipeID;
        $output .= '/ '.$this->description;
        $output .= '/ '.$this->requiredItems;
        $output .= '/ '.$this->requiredBuildings;
        $output .= '/ '.json_encode($this->consumedItems);
        $output .= '/ '.json_encode($this->generatedItems);
        $output .= '/ '.$this->recipeComment;
        $output .= '/ '.$this->recipeImage;
        return $output;
    }

    function returnVars()
    {
        return get_object_vars($this);
    }


    function getRecipeID()
    {
        return $this->recipeID;
    }

    function setRecipeID($var)
    {
        $this->recipeID = $var;
    }

    function getDescription()
    {
       return $this->description;
    }

    function setDescription($var)
    {
        $this->description = $var;
    }

    function getRequiredItems()
    {
        return $this->requiredItems;
    }

    function setRequiredItems($var)
    {
        $this->requiredItems = $var;
    }

    function getRequiredBuildings()
    {
        return $this->requiredBuildings;
    }

    function setRequiredBuildings($var)
    {
        $this->requiredBuildings = $var;
    }

    function getConsumedItems()
    {
        return $this->consumedItems;
    }

    function setConsumedItems($var)
    {
        $this->consumedItems = $var;
    }

    function getGeneratedItems()
    {
        return $this->generatedItems;
    }

    function setGeneratedItems($var)
    {
        $this->generatedItems = $var;
    }

    function getRecipeComment(){
        return $this->recipeComment;
    }

    function setRecipeComment($var)
    {
        $this->recipeComment = $var;
    }

    function getRecipeImage()
    {
        return $this->recipeImage;
    }

    function setRecipeImage($var)
    {
        $this->recipeImage = $var;
    }

    public static function findRecipe($itemArray,$buildingArray,$object){
        $recipeArrayFinal = [];
        foreach ($itemArray as $itemID){
            $name = "item".$itemID;
            $item = new $name();
            if ($item->getGivesRecipe() !== null){
                foreach ($item->getGivesRecipe() as $recipeID) {
                    $name = "recipe" . $recipeID;
                    $recipe = new $name();
                    if ($object === true) {
                        $recipeArrayFinal[$recipeID] = $recipe;
                    } else {
                        $recipeArrayFinal[$recipeID] = $recipe->returnVars();
                    }
                }
            }
        }
        foreach ($buildingArray as $buildingID){
            $name = "building".$buildingID;
            $building = new $name();
            if ($building->getGivesRecipe() !== null) {
                foreach ($building->getGivesRecipe() as $recipeID) {
                    $name = "recipe" . $recipeID;
                    $recipe = new $name();
                    if ($object === true) {
                        $recipeArrayFinal[$recipeID] = $recipe;
                    } else {
                        $recipeArrayFinal[$recipeID] = $recipe->returnVars();
                    }
                }
            }
        }
        return $recipeArrayFinal;
    }
}