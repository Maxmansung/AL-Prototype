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
interface IZone {
    public function getZoneID();
    public function setZoneID($zoneID);
    public function getName();
    public function setName($name);
    public function getMapID();
    public function setMapID($mapID);
    public function getCoordinateX();
    public function setCoordinateX($coordinate);
    public function getCoordianteY();
    public function setCoordinateY($coordinate);
    public function getAvatars();
    public function addAvatar($avatarID);
    public function removeAvatar($avatarID);
    public function getItems();
    public function addItem($itemID);
    public function removeItem($itemID);
    public function getBuildings();
    public function addBuilding($buildingID);
    public function removeBuilding($buildingID);
    public function getControllingParty();
    public function setControllingParty($partyID);
    public function isRestricted();
    public function teoggleRestricted();
    public function getStorage();
    public function setStorage($storageID);
    public function getFindingChances();
    public function addFindingChance($itemID);
    public function removeFindingChance($itemID);
    public function getExplorationStatus();
    public function setExplorationStatus($explorationStatus);
    public function getBiomeType();
    public function setBiomeType($biomeType);
    public function getZoneNightTemperatureModifier();
    public function setZoneNightTemperatureModifier($newModifier);
    public function getZoneSurvivableTemperatureModifier();
    public function setZoneSurvivableTemperatureModifier($newModifier);
    public function getZoneNightTemperature();
    public function setZoneNightTemperature();
}
