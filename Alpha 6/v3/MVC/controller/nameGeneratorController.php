<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/nameGenerator.php");
require_once(PROJECT_ROOT."/MVC/model/nameGeneratorModel.php");
class nameGeneratorController extends nameGenerator
{

    private function __construct($first, $middle, $last)
    {
        $this->firstName = $first;
        $this->middleName = $middle;
        $this->lastName = $last;
    }

    public static function createNewName($type){
        if ($type === "map"){
            $nameList = nameGeneratorModel::nameList("map");
            $returnItem = self::createMapName($nameList);
        } elseif ($type === "camp"){
            $nameListFirst = nameGeneratorModel::nameList("map");
            $nameList = nameGeneratorModel::nameList("camp");
            $returnItem =  self::createTownName($nameListFirst,$nameList);
        } elseif ($type === "party"){
            $nameListFirst = nameGeneratorModel::nameList("map");
            $nameList = nameGeneratorModel::nameList("party");
            $returnItem = self::createPartyName($nameListFirst,$nameList);
        } else {
            $returnItem =  array("ERROR"=>"Wrong Type of name");
        }
        return $returnItem;
    }

    private static function createMapName($nameList){
        $length = count($nameList);
        $firstNum = rand(0,$length-1);
        $middleNum = rand(0,$length-1);
        $lastNum = rand(0,$length-1);
        $first = $nameList[$firstNum]['firstName'];
        $middle = $nameList[$middleNum]['middleName'];
        $last = $nameList[$lastNum]['lastName'];
        return new nameGeneratorController($first,$middle,$last);
    }

    private static function createTownName($nameListFirst,$nameListMid){
        $firstNum = rand(0,count($nameListFirst)-1);
        $middleNum = rand(0,count($nameListMid)-1);
        $first = $nameListFirst[$firstNum]['firstName'];
        $middle = $nameListMid[$middleNum]['middleName'];
        return new nameGeneratorController($first,$middle,"");
    }

    private static function createPartyName($nameListFirst,$nameListMid){
        $firstNum = rand(0,count($nameListFirst)-1);
        $middleNum = rand(0,count($nameListMid)-1);
        $first = $nameListFirst[$firstNum]['firstName'];
        $middle = $nameListMid[$middleNum]['middleName'];
        return new nameGeneratorController($first,$middle,"");
    }

    public static function getNameAsText($type){
        $name = self::createNewName($type);
        if (array_key_exists("ERROR",$name)){
            return $name;
        } else {
            $returnName = $name->getFirstName() . " " . $name->getMiddleName() . " " . $name->getLastName();
            return $returnName;
        }
    }
}