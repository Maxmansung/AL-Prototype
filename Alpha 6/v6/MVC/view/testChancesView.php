<?php
class testChancesView
{

    static $viewTest = 10000;

    protected $biomeName;
    protected $noneChance;
    protected $quadChance;
    protected $tripleChance;
    protected $doubleChance;
    protected $singleChance;
    protected $itemArray;

    function __construct($none, $single, $double, $triple, $quad, $name, $array)
    {
        $this->biomeName = $name;
        $this->noneChance = round(($none/($none+$single+$double+$triple+$quad))*100,1);
        $this->doubleChance = round(($double/($none+$single+$double+$triple+$quad))*100,1);
        $this->singleChance = round(($single/($none+$single+$double+$triple+$quad))*100,1);
        $this->quadChance = round(($quad/($none+$single+$double+$triple+$quad))*100,1);
        $this->tripleChance = round(($triple/($none+$single+$double+$triple+$quad))*100,1);
        $chanceWithDouble = ($single+$double+$double)/($none+$single+$double+$double);
        $total = 0;
        $final = [];
        foreach ($array as $count){
            $total += $count;
        }
        foreach ($array as $item=>$count){
            $temp = "item".$item;
            $class = new $temp();
            $single = round(((($count/$total)*$chanceWithDouble)*100),1);
            $final[$class->getIcon()] = $single;
        }
        $this->itemArray = $final;

    }

    function returnVars(){
        return get_object_vars($this);
    }

    static function createView($modifier)
    {
        $modifierClean = (intval($modifier)*-1);
        $biomes = factoryClassArray::$biomesAll;
        unset($biomes[0]);
        $finalArray = [];
        foreach ($biomes as $biome){
            $location = new $biome();
            $single = 0;
            $none = 0;
            $double = 0;
            $triple = 0;
            $quad = 0;
            $itemArray = [];
            for($x = 0;$x<testChancesView::$viewTest;$x++) {
                $result = playerMapZoneController::findingChances($location, $modifierClean, 2, true);
                if ($result === 0){
                    $none++;
                } elseif ($result === 1){
                    $single++;
                } elseif ($result === 2){
                    $double++;
                } elseif ($result === 3){
                    $triple++;
                } elseif ($result === 4){
                    $quad++;
                }
                $item = $location->findItem();
                if (key_exists($item,$itemArray)){
                    $itemArray[$item]++;
                } else {
                    $itemArray[$item] = 1;
                }
            }
            $temp = new testChancesView($none,$single,$double,$triple,$quad,$location->getValue(),$itemArray);
            $finalArray[$biome] = $temp->returnVars();
        }
        return $finalArray;
    }

}