<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class buildingType1 extends buildingType
{
    function __construct()
    {
        $this->typeID = 1;
        $this->typeName = "Fires";
        $this->typeDescription = "Buildings that use fire or the firepit";
    }

}