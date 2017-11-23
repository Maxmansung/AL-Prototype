<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/storage.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/storageModel.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/data/buildingLevels.php");
class storageController extends storage
{

    public function __construct($id,$zone)
    {
        if ($id != "" || $zone != "") {
            $checkStorage = storageModel::getStorage($id,$zone);
            $this->storageID = $checkStorage->getStorageID();
            $this->zoneID = $checkStorage->getZoneID();
            $this->items = $checkStorage->getItems();
            $this->maximumCapacity = $checkStorage->getMaximumCapacity();
            $this->storageLevel = $checkStorage->getStorageLevel();
        }
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
    }

    public function upgradeStorage(){
        $this->storageLevel += 1;
        $this->maximumCapacity += 5;
        $this->uploadStorage();
    }

    public function checkUpgradeCost(){
        return buildingLevels::storageUpgradeCost($this->storageLevel);
    }
}