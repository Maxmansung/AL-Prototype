<?php
class factoryClassArray
{
    static $biomesAll = ["biome100","biome1","biome2","biome3","biome4","biome5","biome6","biome7","biome8","biome9","biome10","biome11","biome12","biome13"];
    static $itemsAll = ["item1","item2","item3","item4","item5","item6","item7","item8","item9","item10","item11","item12","item13","item14","item15","item16","item17","item18","item19","item20","item21","item22","item23","item24","item25","item26","item27","item28","item29","item30","item31","item32","item33","item34","item35","item36","item37","item38","item39"];
    static $shrineAll = [];
    static $buildingAll = ["building1","building2","building3","building4","building5","building6","building7","building8","building9","building10","building11","building12","building13","building14","building15","building16","building17","building18","building19","building20","building21","building22","building23","building24","building25"];
    static $buildingTypeAll = ["buildingType1","buildingType2","buildingType3","buildingType4","buildingType5"];
    static $recipeAll = ["recipe1","recipe2","recipe3","recipe4","recipe5","recipe6","recipe7","recipe8","recipe9","recipe10","recipe11","recipe12","recipe13","recipe14","recipe15","recipe16","recipe17","recipe18","recipe19","recipe20","recipe21","recipe22","recipe23"];
    static $statusAll = ["status1","status2","status3","status4","status5","status6"];
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