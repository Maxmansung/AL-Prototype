<?php
interface recipe_Interface
{

    function getRecipeID();
    function setRecipeID($var);
    function getDescription();
    function setDescription($var);
    function getRequiredItems();
    function setRequiredItems($var);
    function getRequiredBuildings();
    function setRequiredBuildings($var);
    function getConsumedItems();
    function setConsumedItems($var);
    function getGeneratedItems();
    function setGeneratedItems($var);
}