<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class buildingType
{

    protected $typeID;
    protected $typeName;
    protected $typeDescription;

    function getTypeID(){
        return $this->typeID;
    }

    function setTypeID($var){
        $this->typeID = $var;
    }

    function getTypeName(){
        return $this->typeName;
    }

    function setTypeName($var){
        $this->typeName = $var;
    }

    function getTypeDescription(){
        return $this->typeDescription;
    }

    function setTypeDescription($var){
        $this->typeDescription = $var;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    function __construct($id)
    {
        if ($id !== ""){
            $typeModel = buildingModel::getBuildingTypeDetails($id);
            $this->typeID = $typeModel['value'];
            $this->typeName = $typeModel['typeName'];
            $this->typeDescription = $typeModel['typeDescription'];
        }
    }

}