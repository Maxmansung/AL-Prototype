<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT."/MVC/interface/recipe_Interface.php");
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
        $output .= '/ '.$this->consumedItems;
        $output .= '/ '.$this->generatedItems;
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
}