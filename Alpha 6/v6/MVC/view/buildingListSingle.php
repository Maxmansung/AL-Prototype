<?php
class buildingListSingle
{
    protected $name;
    protected $description;
    protected $itemsRequired;
    protected $buildingsRequired;
    protected $staminaRequired;
    protected $longDescription;
    protected $header;
    protected $image;
    protected $recipes;
    protected $heat;

    function __construct($buildingClass,$type)
    {
        if ($type === "head"){
            $this->header = true;
            $this->name = $buildingClass->getTypeName();
            $this->image = $buildingClass->getTypeID();
            $this->longDescription = $buildingClass->getLongDescription();
            $this->description = $buildingClass->getTypeDescription();
        } else if ($type === "build") {
            $this->header = false;
            $this->name = $buildingClass->getName();
            $this->description = $buildingClass->getDescription();
            $this->itemsRequired =  $this->createItemsArray($buildingClass->getItemsRequired());
            $this->buildingsRequired = $buildingClass->getBuildingsRequired();
            $this->staminaRequired = $buildingClass->getStaminaRequired();
            $this->longDescription = $buildingClass->getLongDescription();
            $this->image = $buildingClass->getIcon();
            $this->recipes = $this->createRecipesArray($buildingClass->getGivesRecipe());
            $this->heat = $buildingClass->getHeatDescription();
        }
    }

    function returnVars()
    {
        return get_object_vars($this);
    }

    public static function getBuildingsInfo($id,$type)
    {
        if ($type === "head"){
            $temp = "buildingType".$id;
        } elseif ($type === "build"){
            $temp = "building".$id;
        } else {
            return array("ERROR"=>"Dont mess around with the inputs...");
        }
        $class = new $temp();
        $final = new buildingListSingle($class,$type);
        return $final->returnVars();
    }

    function createItemsArray($itemArray)
    {
        $finalArray = array();
        $counter = 0;
        foreach ($itemArray as $item=>$count){
            $name = "item".$item;
            $class = new $name();
            $final = new buildingItemController($count,0,$class);
            $finalArray[$counter] = $final->returnVars();
            $counter++;
        }
        return $finalArray;
    }

    function createRecipesArray($recipesArray)
    {
        $finalArray = array();
        $counter = 0;
        foreach ($recipesArray as $recipe){
            $name = "recipe".$recipe;
            $class = new $name();
            $array = array("name"=>$class->getDescription(),"icon"=>$class->getRecipeImage());
            $finalArray[$counter] = $array;
            $counter++;
        }
        return $finalArray;
    }
}