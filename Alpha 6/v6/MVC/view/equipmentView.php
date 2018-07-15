<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
class equipmentView extends equipment
{
    function __construct($id)
    {
        if ($id != "") {
            if (is_object($id)) {
                $equipmentModel = $id;
            } else {
                $class = "equipment".$id;
                $equipmentModel = new $class();
            }
            $this->equipmentID = $equipmentModel->getEquipmentID();
            $this->equipName = $equipmentModel->getEquipName();
            $this->heatBonus = $equipmentModel->getHeatBonus();
            $this->backpackBonus = $equipmentModel->getBackpackBonus();
            $name = "item".$equipmentModel->getCost1Item();
            $tempItem = new $name();
            $this->cost1Item = $tempItem->returnVars();
            $this->cost1Count = $equipmentModel->getCost1Count();
            $name = "item".$equipmentModel->getCost2Item();
            $tempItem2 = new $name();
            $this->cost2Item = $tempItem2->returnVars();
            $this->cost2Count = $equipmentModel->getCost2Count();
            $this->upgrade1 = $equipmentModel->getUpgrade1();
            $this->upgrade2 = $equipmentModel->getUpgrade2();
            $this->equipImage = $equipmentModel->getEquipImage();
        }
    }
}