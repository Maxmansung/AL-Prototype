<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/shrine.php");
require_once(PROJECT_ROOT."/MVC/model/shrineModel.php");
class shrineController extends shrine
{
    public function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)){
                $shrineModel = $id;
            } else {
                $shrineModel = shrineModel::getShrineByID($id);
            }
            $this->shrineID = $shrineModel->getShrineID();
            $this->mapID = $shrineModel->getMapID();
            $this->zoneID = $shrineModel->getZoneID();
            $this->shrineType = $shrineModel->getShrineType();
            $this->getShrineFactory($this->getShrineType());
        }
    }

    public static function createBlankShrine($shrineType){
        $shrine = new shrineController("");
        $shrine->getShrineFactory($shrineType);
        return $shrine;
    }

    public static function createNewShrine($type,$zoneID)
    {
        $zone = new zoneController($zoneID);
        $shrine = new shrineController("");
        $shrine->setMapID($zone->getMapID());
        $shrine->setZoneID($zone->getZoneID());
        $shrine->setShrineType($type);
        return $shrine;
    }

    function insertShrine(){
        shrineModel::insertShrine($this,"Insert");
    }

    function updateShrine(){
        shrineModel::insertShrine($this,"Update");
    }

    public static function findShrine($zoneID){
        $temp = shrineModel::findShrineInZone($zoneID);
        return new shrineController($temp);
    }

    public static function findMapShrines($mapID){
        $temp = shrineModel::getMapShrines($mapID);
        $finalArray = [];
        $counter = 0;
        foreach ($temp as $shrine){
            $current = new shrineController($shrine);
            $finalArray[$counter] = $current;
            $counter++;
        }
        return $finalArray;
    }
}