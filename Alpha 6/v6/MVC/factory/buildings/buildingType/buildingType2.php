<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class buildingType2 extends buildingType
{
    function __construct()
    {
        $this->typeID = 2;
        $this->typeName = "Protection";
        $this->typeDescription = "Buildings that keep strangers out and protect your stuff";
    }

    function getLongDescription(){
        return "This is a longer description of the building type";
    }

}