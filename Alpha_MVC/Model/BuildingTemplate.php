<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BuildingTemplate
 *
 * @author Falk (Nefasu) <Falk.Testing@web.de>
 */
class BuildingTemplate implements IBuildingTemplate {
    
    private $buildingTemplateID;
    private $name;
    private $icon;
    private $description;
    private $itemsReuired;
    private $buildingsRequired;
    private $staminaRequired;
    
    public function addBuildingRequirement($buildingID) {
        $this->buildingsRequired[] = $buildingID;
    }

    public function addItemRequirement($itemID) {
        $this->itemsReuired[] = $itemID;
    }

    public function gerDescription() {
        return $this->description;
    }

    public function getBuildingTemplateID() {
        return $this->buildingTemplateID;
    }

    public function getBuildingsRequired() {
        return $this->buildingsRequired;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getItemsRequired() {
        return $this->itemsReuired;
    }

    public function getName() {
        
    }

    public function getStaminaRequired() {
        
    }

    public function removeBuildingRequirement($buildingID) {
        
    }

    public function removeItemRequirement($itemID) {
        
    }

    public function setBuildingTemplateID($id) {
        
    }

    public function setDecription($description) {
        
    }

    public function setIcon($path) {
        
    }

    public function setName($name) {
        
    }

    public function setStaminaRequired($stamina) {
        
    }

}
