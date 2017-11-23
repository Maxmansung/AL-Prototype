<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/connection/db_conx.php");
class recipeModel extends recipe
{

    private function __construct($recipeModel)
    {
        $this->recipeID = $recipeModel['recipeID'];
        $this->description = $recipeModel['description'];
        $this->requiredItems = $recipeModel['requiredItems'];
        $this->requiredBuildings = $recipeModel['requiredBuildings'];
        $this->consumedItems = json_decode($recipeModel['consumedItems']);
        $this->generatedItems = json_decode($recipeModel['generatedItems']);
    }

    public static function findRecipe($recipeID){
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM Recipe WHERE recipeID= :recipeID LIMIT 1");
        $req->execute(array(':recipeID' => $recipeID));
        $recipeModel = $req->fetch();
        return new recipeModel($recipeModel);
    }

    public static function recipesRequiringBuilding($buildingArray){
        $buildingString = "";
        foreach ($buildingArray as $building){
            $buildingString .= "'".$building."',";
        }
        $buildingString = rtrim($buildingString,",");
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM Recipe WHERE requiredBuildings IN (".$buildingString.")");
        $req->execute();
        $recipeModel = $req->fetchAll();
        $foundRecipes = [];
        foreach ($recipeModel as $recipe) {
            $newObject = new recipeModel($recipe);
            $foundRecipes[$newObject->getRecipeID()] = $newObject->returnVars();
        }
        return $foundRecipes;
    }

    public static function recipesRequiringItem($itemArray){
        $itemString = "";
        foreach ($itemArray as $item){
            $itemString .= "'".$item."',";
        }
        $itemString = rtrim($itemString,",");
        $db = db_conx::getInstance();
        $req = $db->prepare("SELECT * FROM Recipe WHERE requiredItems IN (".$itemString.")");
        $req->execute();
        $recipeModel = $req->fetchAll();
        $foundRecipes = [];
        foreach ($recipeModel as $recipe) {
            $newObject = new recipeModel($recipe);
            $foundRecipes[$newObject->getRecipeID()] = $newObject->returnVars();
        }
        return $foundRecipes;
    }
}