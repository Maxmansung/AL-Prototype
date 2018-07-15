<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class buildingType3 extends buildingType
{
    function __construct()
    {
        $this->typeID = 3;
        $this->typeName = "Hunting";
        $this->typeDescription = "Buildings to catch and kill wildlife";
    }

}