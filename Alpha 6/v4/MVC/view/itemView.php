<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class itemView extends item
{

    function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)) {
                $itemObject = $id;
                $this->itemTemplateID = $itemObject->itemTemplateID;
                $this->identity = $itemObject->identity;
                $this->icon = $itemObject->icon;
                $this->description = $itemObject->description;
                $this->itemType = $itemObject->itemType;
                $this->usable = $itemObject->usable;
                $this->survivalBonus = $itemObject->survivalBonus;
            }
        }
    }

    public static function getArrayView($array){
        $count = 0;
        $finalArray = [];
        foreach ($array as $itemID){
            $name = "item".$itemID;
            $class = new $name();
            $view = new itemView($class);
            $finalArray[$count] = $view->returnVars();
            $count++;
        }
        return $finalArray;
    }

    public static function getAllItemsView($locationType,$object){
        if ($locationType === "ground"){
            $array = $object->getZoneItems();
        } elseif ($locationType === "backpack") {
            $array = $object->getInventory();
        } elseif ($locationType === "storage"){
            $array = $object->getItems();
        } else {
            $array = [];
        }
        sort($array);
        $count = 0;
        $finalArray = [];
        foreach ($array as $item){
            $name = "item".$item;
            $class = new $name();
            $temp = new itemView($class);
            $finalArray[$count] = $temp->returnVars();
            $count++;
        }
        return $finalArray;
    }
}