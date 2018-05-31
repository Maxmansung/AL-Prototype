<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/storage.php");
require_once(PROJECT_ROOT."/MVC/model/storageModel.php");
class storageController extends storage
{

    public function __construct($id,$zone)
    {
        if ($id != "" || $zone != ""){
            if (is_object($id)){
                $checkStorage = $id;
            } else {
                $checkStorage = storageModel::getStorage($id,$zone);
            }
            $this->storageID = $checkStorage->getStorageID();
            $this->zoneID = $checkStorage->getZoneID();
            $this->items = $checkStorage->getItems();
            $this->maximumCapacity = $checkStorage->getMaximumCapacity();
            $this->storageLevel = $checkStorage->getStorageLevel();
            $this->lockBuilt = $checkStorage->getLockBuilt();
            $this->lockStrength = $checkStorage->getLockStrength();
            $this->lockMax = $checkStorage->getLockMax();
        }
    }

    public function storageView(){
        return $this->returnVars();
    }

    public function uploadStorage(){
        storageModel::insertStorage($this,"Update");
    }

    public function insertStorage(){
        storageModel::insertStorage($this,"Insert");
    }

    public function createStorage($zone, $maximum){
        $this->zoneID = $zone;
        $this->items = array();
        $this->maximumCapacity = $maximum;
        $this->storageLevel = 1;
        $this->lockStrength = 0;
        $this->lockBuilt = 0;
        $this->lockMax = 0;
    }
}