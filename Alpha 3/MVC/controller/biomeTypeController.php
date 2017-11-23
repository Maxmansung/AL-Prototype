<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/biomeType.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/model/biomeTypeModel.php");
class biomeTypeController extends biomeType
{
    public function __construct($id)
    {
        if ($id != ""){
            $biomeModel = biomeTypeModel::getBiomeType($id);
            $this->depth = $biomeModel->depth;
            $this->value = $biomeModel->value;
            $this->description = $biomeModel->description;
            $this->descriptionLong = $biomeModel->descriptionLong;
            $this->temperatureMod = $biomeModel->temperatureMod;
            $this->findingChanceMod = $biomeModel->findingChanceMod;
        }
    }

}