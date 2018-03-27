<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/recipe.php");
require_once(PROJECT_ROOT."/MVC/model/recipeModel.php");
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
            $this->recipeComment = $recipe->recipeComment;
            $this->recipeImage = $recipe->recipeImage;
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
                        return array("ITEM"=>"I0008");
                        break;
                    case "1":
                        return  array("ITEM"=>"I0009");
                        break;
                    case "2":
                        return  array("ITEM"=>"I0010");
                        break;
                    default:
                        return  array("ITEM"=>"I0007");
                        break;
                }
                break;
            case "R0004":
                return array("STAMINA"=>5);
                break;
            case "R0010":
                return array("SEARCH"=>5);
            case "R0011":
                return array("STAMINA"=>10);
            case "R0014":
                return array("STAMINA"=>5);
            default:
                return "I0001";
                break;
        }
    }

}