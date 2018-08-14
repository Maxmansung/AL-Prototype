<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class recipe16 extends recipe
{
    function __construct()
    {
        $this->recipeID = 16;
        $this->description = "Smash stone";
        $this->requiredItems = 11;
        $this->requiredBuildings = null;
        $this->consumedItems = array(11,11);
        $this->generatedItems = array("OTHER"=>1);
        $this->recipeComment = "You smash the two rocks together until finally they split, inside you see ";
        $this->recipeImage = "testImage";
    }

    function differentResult(){
        $num = rand(0,6);
        if ($num === 0){
            $this->recipeComment = "You smash the two rocks together constantly until they fall to pieces, inside you catch a glimmer of light and you realise that you've found a hidden crystal!";
            return array("ITEM"=>32);
        } else if ($num > 0 && $num <= 2){
            $this->recipeComment = "You smash the rocks together over and over again in the vain hope of finding something useful. In the end you are left with just a pile of powdered stone.";
            return array("ITEM"=>36);
        } else if ($num > 2 && $num <= 4){
            $this->recipeComment = "After some heavy smashing the stone breaks in half and inside you find a small vein of shining stone. Perhaps this could be melted into something useful?";
            return array("ITEM"=>33);
        } else {
            $this->recipeComment = "As you smash the two stones together one of them splinters into pieces and realise it was a piece of flint all along.";
            return array("ITEM"=>6);
        }
    }
}