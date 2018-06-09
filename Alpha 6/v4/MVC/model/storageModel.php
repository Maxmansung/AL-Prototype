<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class storageModel extends storage
{
    private function __construct($storageModel)
    {
        $this->storageID = intval($storageModel['storageID']);
        $this->zoneID = intval($storageModel['zoneID']);
        $this->items = json_decode($storageModel['items']);
        $this->maximumCapacity = intval($storageModel['maximumCapacity']);
        $this->storageLevel = intval($storageModel['storageLevel']);
        $this->lockBuilt = intval($storageModel['lockBuilt']);
        $this->lockStrength = intval($storageModel['lockStrength']);
        $this->lockMax = intval($storageModel['lockMax']);
    }



    public static function getStorage($storageID,$zoneID){
        $db = db_conx::getInstance();
        $req = $db->prepare('SELECT * FROM Storage WHERE storageID= :storageID OR zoneID= :zoneID LIMIT 1');
        $req->bindParam(':storageID', $storageID);
        $req->bindParam(':zoneID', $zoneID);
        $req->execute();
        $storageModel = $req->fetch();
        return new storageModel($storageModel);
    }


    public static function insertStorage($storageController, $type){
        $db = db_conx::getInstance();
        $storageID = intval($storageController->getStorageID());
        $zoneID = intval($storageController->getZoneID());
        $items = json_encode($storageController->getItems());
        $maximumCapacity = intval($storageController->getMaximumCapacity());
        $storageLevel = intval($storageController->getStorageLevel());
        $lockBuilt = intval($storageController->getLockBuilt());
        $lockStrength = intval($storageController->getLockStrength());
        $lockMax = intval($storageController->getLockMax());
        if ($type == "Insert") {
            $req = $db->prepare("INSERT INTO Storage (zoneID, items, maximumCapacity, storageLevel,lockBuilt,lockStrength,lockMax) VALUES (:zoneID,:items,:maximumCapacity, :storageLevel,:lockBuilt,:lockStrength, :lockMax)");
        } elseif ($type == "Update"){
            $req = $db->prepare("UPDATE Storage SET zoneID= :zoneID, items= :items,maximumCapacity= :maximumCapacity, storageLevel= :storageLevel, lockBuilt= :lockBuilt, lockStrength= :lockStrength, lockMax= :lockMax WHERE storageID= :storageID");
            $req->bindParam(':storageID', $storageID);
        }
        $req->bindParam(':zoneID', $zoneID);
        $req->bindParam(':items', $items);
        $req->bindParam(':maximumCapacity', $maximumCapacity);
        $req->bindParam(':storageLevel', $storageLevel);
        $req->bindParam(':lockBuilt', $lockBuilt);
        $req->bindParam(':lockStrength', $lockStrength);
        $req->bindParam(':lockMax', $lockMax);
        $req->execute();
    }

}