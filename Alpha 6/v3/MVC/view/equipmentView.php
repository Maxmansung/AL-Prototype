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
            $tempItem = new itemController("");
            $tempItem->createBlankItem($equipmentModel->getCost1Item());
            $this->cost1Item = $tempItem->returnVars();
            $this->cost1Count = $equipmentModel->getCost1Count();
            $tempItem2 = new itemController("");
            $tempItem2->createBlankItem($equipmentModel->getCost2Item());
            $this->cost2Item = $tempItem2->returnVars();
            $this->cost2Count = $equipmentModel->getCost2Count();
            $this->upgrade1 = $equipmentModel->getUpgrade1();
            $this->upgrade2 = $equipmentModel->getUpgrade2();
            $this->equipImage = $equipmentModel->getEquipImage();
        }
    }
}