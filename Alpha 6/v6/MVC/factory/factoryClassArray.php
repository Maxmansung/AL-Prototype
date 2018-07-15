<?php
class factoryClassArray
{
    static $biomesAll = ["biome100","biome1","biome2","biome3","biome4","biome5","biome6","biome7","biome8","biome9","biome10","biome11","biome12"];
    static $itemsAll = ["item1","item2","item3","item4","item5","item6","item7","item8","item9","item10","item11","item12","item15","item16","item17","item18","item19","item20","item21",];
    static $shrineAll = [];
    static $buildingAll = ["building1","building2","building3","building4","building5","building6","building7","building8","building9","building10","building11","building12","building13"];
    static $recipeAll = [];
    static $statusAll = ["status1","status2","status3","status4","status5"];
    static $equipmentAll = ["equipment1","equipment2","equipment3","equipment4","equipment5","equipment6","equipment7","equipment8","equipment9","equipment10","equipment11","equipment12"];

    public static function createAllItems()
    {
        $itemObjects = [];
        foreach (factoryClassArray::$itemsAll as $item)
        {
            $temp = new $item();
            $itemObjects[$temp->getItemTemplateID()] = $temp;
        }
        return $itemObjects;
    }

    public static function createAllStatuses()
    {
        $statusObjects = [];
        foreach (factoryClassArray::$statusAll as $status)
        {
            $temp = new $status();
            $statusObjects[$temp->getStatusID()] = $temp;
        }
        return $statusObjects;
    }

    public static function createAllBuildings()
    {
        $buildingObjects = [];
        foreach (factoryClassArray::$buildingAll as $building)
        {
            $temp = new $building();
            $buildingObjects[$temp->getBuildingTemplateID()] = $temp;
        }
        return $buildingObjects;
    }

}