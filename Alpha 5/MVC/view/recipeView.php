<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class recipeView
{

    protected $recipeID;
    protected $description;
    protected $recipeImage;

    private function __construct($recipeController)
    {
        $this->recipeID = $recipeController->getRecipeID();
        $this->description = $recipeController->getDescription();
        $this->recipeImage = $recipeController->getRecipeImage();
    }

    public function returnVars(){
        return get_object_vars($this);
    }

    public static function getRecipeView($itemList,$buildingList){
        $list = recipeController::findRecipe($itemList,$buildingList);
        $final = [];
        foreach ($list as $recipe){
            $tempView = new recipeView($recipe);
            array_push($final,$tempView->returnVars());
        }
        return $final;
    }

}