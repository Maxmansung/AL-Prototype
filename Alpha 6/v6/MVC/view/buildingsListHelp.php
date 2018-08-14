<?php
class buildingsListHelp
{
    protected $buildingTemplateID;
    protected $name;
    protected $buildingTypeID;
    protected $isHeader;

    function __construct($id,$name,$type,$header)
    {
        $this->buildingTemplateID = $id;
        $this->name = $name;
        $this->buildingTypeID = $type;
        $this->isHeader = $header;
    }

    function returnVars(){
        return get_object_vars($this);
    }

    public static function createBuildingsList()
    {
        $list1 = factoryClassArray::$buildingTypeAll;
        $finalArray = array();
        $tempArray = array();
        foreach ($list1 as $header){
            $temp = new $header();
            $item = new buildingsListHelp($temp->getTypeID(),$temp->getTypeName(),$temp->getTypeID(),true);
            $tempArray[$temp->getTypeID()] = $item->returnVars();
        }
        $finalArray["head"] = $tempArray;
        $list2 = factoryClassArray::$buildingAll;
        $tempArray = array();
        foreach ($list2 as $building){
            $temp = new $building();
            $item = new buildingsListHelp($temp->getBuildingTemplateID(), $temp->getName(),$temp->getBuildingTypeID(),false);
            $tempArray[$temp->getBuildingTemplateID()] = $item->returnVars();
        }
        $finalArray["build"] = $tempArray;
        return $finalArray;
    }

}