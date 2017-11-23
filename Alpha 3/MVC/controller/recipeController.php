<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/recipe.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/recipeModel.php");
class recipeController extends recipe
{

    public function __construct($id)
    {
        if ($id != ""){
            $recipe = recipeModel::findRecipe($id);
            $this->recipeID = $recipe->recipeID;
            $this->description = $recipe->description;
            $this->requiredItems = $recipe->requiredItems;
            $this->requiredBuildings = $recipe->requiredBuildings;
            $this->consumedItems = $recipe->consumedItems;
            $this->generatedItems = $recipe->generatedItems;
        }
    }

    public static function findRecipe($itemArray,$buildingArray){
        $recipeArray1 = recipeModel::recipesRequiringItem($itemArray);
        $recipeArray2 = recipeModel::recipesRequiringBuilding($buildingArray);
        $recipeArrayFinal = array_merge($recipeArray1,$recipeArray2);
        return $recipeArrayFinal;
    }

    public static function differentResult($recipeID){
        switch ($recipeID){
            case "R0003":
                $rand = rand(0,2);
                switch ($rand) {
                    case "0":
                        return "I0008";
                        break;
                    case "1":
                        return "I0009";
                        break;
                    case "2":
                        return "I0010";
                        break;
                    default:
                        return "I0001";
                        break;
                }
                break;
            case "R0004":
                return array("STAMINA"=>5);
            default:
                return "I0001";
                break;
        }
    }

}