<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class itemView extends item
{

    function __construct($id)
    {
        if ($id != ""){
            if (is_object($id)) {
                $itemModel = $id;
                $this->itemID = $itemModel->itemID;
                $this->mapID = "";
                $this->itemTemplateID = $itemModel->itemTemplateID;
                $this->identity = $itemModel->identity;
                $this->icon = $itemModel->icon;
                $this->description = $itemModel->description;
                $this->itemType = $itemModel->itemType;
                $this->findingChances = "";
                $this->maxCharges = $itemModel->maxCharges;
                $this->currentCharges = $itemModel->currentCharges;
                $this->itemStatus = $itemModel->itemStatus;
                $this->usable = $itemModel->usable;
                $this->survivalBonus = $itemModel->survivalBonus;
                $this->itemLocation = "";
                $this->locationID = "";
                $this->statusImpact = "";
            }
        }
    }

    public static function getAllItemsView($mapID,$locationType,$locationID){
        $array = itemModel::getItemsFromLocation($mapID,$locationType,$locationID);
        $finalArray = [];
        foreach ($array as $key=>$item){
            $temp = new itemView($item);
            $finalArray[$key] = $temp->returnVars();
        }
        return $finalArray;
    }
}