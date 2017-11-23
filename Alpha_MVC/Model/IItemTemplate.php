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
interface IItemTemplate {
    public function getItemTemplateID();
    public function setItemTemplateID($itemTemplateID);
    public function getName();
    public function setName($name);
    public function getIcon();
    public function setIcon($path);
    public function getDescription();
    public function setDescription($description);
    public function getItemType();
    public function setItemType($itemType);
    public function getFindingCHances();
    public function addFindingChance($biomeType, $findingChance);
    public function removeFindingChance($biomeType);
    public function getFuelValue();
    public function setFuelValue($fuelValue);
    public function getMaxCharges();
    public function setMaxCharges($maxCharges);
}
