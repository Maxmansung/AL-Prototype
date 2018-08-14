<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class buildingType5 extends buildingType
{
    function __construct()
    {
        $this->typeID = 5;
        $this->typeName = "Incantation";
        $this->typeDescription = "These powers come at a great cost to both you and the world around";
    }

}