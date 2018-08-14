<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class buildingType4 extends buildingType
{
    function __construct()
    {
        $this->typeID = 4;
        $this->typeName = "Technology";
        $this->typeDescription = "Here you can create more complex items";
    }

    function getLongDescription(){
        return "This is a longer description of the building type";
    }

}