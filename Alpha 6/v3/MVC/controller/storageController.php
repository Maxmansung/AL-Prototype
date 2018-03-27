<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/baseController/storage.php");
require_once(PROJECT_ROOT."/MVC/model/storageModel.php");
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

    public function storageView(){
        $this->setUpgradeObjects();
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
    }

    public function upgradeStorage(){
        $this->storageLevel += 1;
        $this->maximumCapacity += 5;
        $this->uploadStorage();
    }

    public function checkUpgradeCost(){
        return buildingLevels::storageUpgradeCost($this->storageLevel);
    }

    private function setUpgradeObjects(){
        $upgrade = $this->checkUpgradeCost();
        $itemsArray = [];
        foreach ($upgrade as $item => $count) {
            $itemObject = new itemController("");
            $itemObject->createBlankItem($item);
            for ($x = 0; $x < $count; $x++) {
                $itemsArray[$itemObject->getIdentity() . $x] = $itemObject->returnVars();
            }

        }
        $this->upgradeItems = $itemsArray;
    }
}