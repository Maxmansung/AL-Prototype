<?php
class testChancesView
{

    static $viewTest = 10000;

    protected $biomeName;
    protected $noneChance;
    protected $doubleChance;
    protected $singleChance;
    protected $itemArray;

    function __construct($none, $single, $double, $name, $array)
    {
        $this->biomeName = $name;
        $this->noneChance = round(($none/($none+$single+$double))*100,1);
        $this->doubleChance = round(($double/($none+$single+$double))*100,1);
        $this->singleChance = round(($single/($none+$single+$double))*100,1);
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
        $biomes = ["biome1","biome2","biome3","biome4","biome5","biome6"];
        $finalArray = [];
        foreach ($biomes as $biome){
            $location = new $biome();
            $single = 0;
            $none = 0;
            $double = 0;
            $itemArray = [];
            for($x = 0;$x<testChancesView::$viewTest;$x++) {
                $result = playerMapZoneController::findingChances($location, $modifierClean, 2, true);
                if ($result === 0){
                    $none++;
                } elseif ($result === 1){
                    $single++;
                } elseif ($result === 2){
                    $double++;
                }
                $item = $location->findItem();
                if (key_exists($item,$itemArray)){
                    $itemArray[$item]++;
                } else {
                    $itemArray[$item] = 1;
                }
            }
            $temp = new testChancesView($none,$single,$double,$location->getValue(),$itemArray);
            $finalArray[$biome] = $temp->returnVars();
        }
        return $finalArray;
    }

}