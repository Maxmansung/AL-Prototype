<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/item.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/itemModel.php");
class itemController extends item
{

    public function __construct($id)
    {
        if ($id != "") {
            $itemModel = itemModel::getItem($id);
            $this->itemID = $itemModel->itemID;
            $this->mapID = $itemModel->mapID;
            $this->itemTemplateID = $itemModel->itemTemplateID;
            $this->identity = $itemModel->identity;
            $this->icon = $itemModel->icon;
            $this->description = $itemModel->description;
            $this->itemType = $itemModel->itemType;
            $this->findingChances = $itemModel->findingChances;
            $this->fuelValue = $itemModel->fuelValue;
            $this->maxCharges = $itemModel->maxCharges;
            $this->currentCharges = $itemModel->currentCharges;
            $this->itemStatus = $itemModel->itemStatus;
            $this->usable = $itemModel->usable;
            $this->survivalBonus = $itemModel->survivalBonus;
        }
    }

    public function createNewItemByID($itemID, $mapID){
        $itemModel = itemModel::newItem($itemID);
        $this->itemID = itemModel::createItemID();
        $this->mapID = $mapID;
        $this->itemTemplateID = $itemModel->itemTemplateID;
        $this->identity = $itemModel->identity;
        $this->icon = $itemModel->icon;
        $this->description = $itemModel->description;
        $this->itemType = $itemModel->itemType;
        $this->findingChances = $itemModel->findingChances;
        $this->fuelValue = $itemModel->fuelValue;
        $this->maxCharges = $itemModel->maxCharges;
        $this->currentCharges = $itemModel->currentCharges;
        $this->itemStatus = $itemModel->itemStatus;
        $this->usable = $itemModel->usable;

    }

    public function createNewItem($biome, $mapID){
        $itemModel = $this->searchItem($biome);
        $this->itemID = itemModel::createItemID();
        $this->mapID = $mapID;
        $this->itemTemplateID = $itemModel->itemTemplateID;
        $this->identity = $itemModel->identity;
        $this->icon = $itemModel->icon;
        $this->description = $itemModel->description;
        $this->itemType = $itemModel->itemType;
        $this->findingChances = $itemModel->findingChances;
        $this->fuelValue = $itemModel->fuelValue;
        $this->maxCharges = $itemModel->maxCharges;
        $this->currentCharges = $itemModel->currentCharges;
        $this->itemStatus = $itemModel->itemStatus;
        $this->usable = $itemModel->usable;
    }

    public function createBlankItem($templateID){
        $itemModel = itemModel::newItem($templateID);
        $this->itemTemplateID = $itemModel->itemTemplateID;
        $this->identity = $itemModel->identity;
        $this->icon = $itemModel->icon;
        $this->description = $itemModel->description;
        $this->itemType = $itemModel->itemType;
    }

    //This uses the array of items found for the biome to randomly select one (based on their chances)
    private function randomiseItem($biome){
        $itemArray = $this->getBiomeItems($biome);
        $chances = 0;
        foreach ($itemArray as $item){
            $chances += $item[1];
        }
        $found = rand(1,$chances);
        $chances = 0;
        foreach ($itemArray as $item){
            $chances += $item[1];
            if ($chances >= $found){
                return $item[0];
            }
        }
        return "Error";
    }

    private function searchItem($biome){
        $templateID = $this->randomiseItem($biome);
        if ($templateID == "Error"){
            return "Error";
        } else {
            return itemModel::newItem($templateID);
        }
    }

    //This returns each of the items within an array (either the backpack or the zone)
    public static function getItemArray($playerArray){
        return itemModel::getItemArray($playerArray);
    }

    //This returns an array of the items found in a specific biome and their finding chances
    private function getBiomeItems($biome){
        return itemModel::findBiomeItems($biome);
    }

    public function nextID(){
        return itemModel::createItemID();
    }

    public function insertItem(){
        itemModel::insertItem($this,"Insert");
    }

    public function updateItem(){
        itemModel::insertItem($this,"Update");
    }

    public function delete(){
        itemModel::deleteItem($this->itemID);
    }

    public static function getAllItems(){
        return itemModel::getAllItemDetails();
    }

    public static function returnItemIDArray($playerArray){
        $itemArray = self::getItemArray($playerArray);
        $itemTypeIDArray = [];
        foreach ($itemArray as $item){
            array_push($itemTypeIDArray,$item["itemTemplateID"]);
        }
        return $itemTypeIDArray;
    }

    public static function changeAllItems($from,$to,$mapID){
        itemModel::changeAllMapItems($from,$to,$mapID);
    }
}