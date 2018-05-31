<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class buildingView extends building
{
    public function __construct($id)
    {
        if ($id != "") {
            if (is_object($id)) {
                $buildingModel = $id;
            } else {
                $buildingModel = buildingModel::getBuilding($id);
            }
            $this->buildingTemplateID = $buildingModel->getBuildingTemplateID();
            $this->name = $buildingModel->getName();
            $this->icon = $buildingModel->getIcon();
            $this->description = $buildingModel->getDescription();
            $this->buildingType = $buildingModel->getBuildingType();
            $this->buildingsRequired = $buildingModel->getBuildingsRequired();
        }
    }



    public static function getAllBuildingsView(){
        $buildingsList = buildingModel::buildingsList();
        $finalArray = [];
        foreach ($buildingsList as $item){
            $temp = new buildingView($item);
            $finalArray[$temp->getBuildingTemplateID()] = $temp;
        }
        return $finalArray;
    }
}
