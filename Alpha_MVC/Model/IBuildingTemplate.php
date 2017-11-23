<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Falk (Nefasu) <Falk.Testing@web.de>
 */
interface IBuildingTemplate {
    public function getBuildingTemplateID();
    public function setBuildingTemplateID($id);
    public function getName();
    public function setName($name);
    public function getIcon();
    public function setIcon($path);
    public function gerDescription();
    public function setDecription($description);
    public function getItemsRequired();
    public function addItemRequirement($itemID);
    public function removeItemRequirement($itemID);
    public function getBuildingsRequired();
    public function addBuildingRequirement($buildingID);
    public function removeBuildingRequirement($buildingID);
    public function getStaminaRequired();
    public function setStaminaRequired($stamina);
}
