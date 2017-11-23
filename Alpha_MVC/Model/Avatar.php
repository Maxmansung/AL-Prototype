<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * The avatar class defines the map specific player object.
 * An avatar represents a player profile for the duration of a games and buffers
 * all relevant data of the player in one object.
 *
 * @author Falk (Nefasu) <Falk.Testing@web.de>
 */
class Avatar implements IAvatar {
    
    private $avatarID;
    private $profileID;
    private $mapID;
    private $stamina;
    private $maxStamina;
    private $zoneID;
    private $inventory;
    private $maxInventorySlots;
    private $partyID;
    private $readiness = false;
    private $zoneExploration;
    private $avatarTemperatureModifier;
    private $avatarSurvivableTemperature;
    private $baseAvatarTemperatureModifier;
    
    public function __construct($avatarID, $profileID, $mapID, 
            $maxStamina, $maxInventorySlots, $baseAvatarTemperatureModifier) {
        $this->avatarID = $avatarID;
        $this->profileID = $profileID;
        $this->mapID = $mapID;
        $this->maxStamina = $maxStamina;
        $this->maxInventorySlots = $maxInventorySlots;
        $this->baseAvatarTemperatureModifier = $baseAvatarTemperatureModifier;
    }
    
    /*
     * This function acts as a constructor for an existing object within the
     * database structure queried via the corresponding SQL command
     * 
     * @return  The fully constructed avatar object 
     * 
     */ 
    public static function sql_construct($avatarID, $profileID, $mapID, $stamina, 
            $maxStamina, $zoneID, $inventory, $maxInventorySlots, $partyID, 
            $readiness, $zoneExploration, $avatarTemperatureModifier, 
            $avatarSurvivableTemperature, $baseAvatarTemperatureModifier) {
        $object = new self($avatarID, $profileID, $mapID, $maxStamina, 
                $maxInventorySlots, $baseAvatarTemperatureModifier);
        $object->stamina = $stamina;
        $object->zoneID = $zoneID;
        $object->inventory = $inventory;
        $object->partyID = $partyID;
        $object->readiness = $readiness;
        $object->zoneExploration = $zoneExploration;
        $object->avatarTemperatureModifier = $avatarTemperatureModifier;
        $object->avatarSurvivableTemperature = $avatarSurvivableTemperature;
        return $object;
    }

    public function calculateAvatarSurvivableTemperature(Zone $zone) {
        $this->avatarSurvivableTemperature = 
                $this->baseAvatarTemperatureModifier 
                + $this->avatarTemperatureModifier 
                + $zone->getZoneSurvivableTemperatureModifier();
    }
    
    public function addItem($itemID) {
        $this->inventory[] = $itemID;
    }

    public function addRecentZone($zoneID, Zone $zone, $timestamp) {
        $this->zoneExploration[$zoneID][] = array($timestamp => $zone);
    }

    public function clearRecentZoneHistory() {
        unset($this->zoneExploration);
        $this->zoneExploration = array();
    }

    public function getAvatarID() {
        return $this->avatarID;
    }

    public function getAvatarSuvivableTemperature() {
        return $this->avatarSurvivableTemperature;
    }

    public function getAvatarTemperatureModifier() {
        return $this->avatarTemperatureModifier;
    }

    public function getPartyID() {
        return $this->partyID;
    }

    public function getInventory() {
        return $this->inventory;
    }

    public function getMapID() {
        return $this->mapID;
    }

    public function getMaxInventorySlots() {
        return $this->maxInventorySlots;
    }

    public function getMaxStamina() {
        return $this->maxStamina;
    }

    public function getProfileID() {
        return $this->profileID;
    }

    public function getStamina() {
        return $this->stamina;
    }

    public function getZoneExploration() {
        return $this->zoneExploration;
    }

    public function getZoneID() {
        return $this->zoneID;
    }

    public function isReady() {
        return $this->readiness;
    }

    public function removeItem($itemID) {
        unset($this->inventory[$itemID]);
    }

    public function setAvatarID($avatarID) {
        $this->avatarID = $avatarID;
    }

    public function setAvatarTemperatureModifier($avatarTemperatureModifier) {
        $this->avatarTemperatureModifier = $avatarTemperatureModifier;
    }

    public function setPartyID($partyID) {
        $this->partyID = $partyID;
    }

    public function setInventory($array) {
        $this->inventory = $array;
    }

    public function setMapID($mapID) {
        $this->mapID = $mapID;
    }

    public function setMaxInventorySlots($maxInventorySlots) {
        $this->maxInventorySlots = $maxInventorySlots;
    }

    public function setMaxStamina($maxStamina) {
        $this->maxStamina = $maxStamina;
    }

    public function setProfileID($profileID) {
        $this->profileID = $profileID;
    }

    public function setStamina($stamina) {
        $this->stamina = $stamina;
    }

    public function setZoneID($zoneID) {
        $this->zoneID = $zoneID;
    }

    public function toggleReady() {
        $this->readiness = !$this->readiness;
    }

    public function getBaseAvatarTemperatureModifier() {
        return $this->baseAvatarTemperatureModifier;
    }

    public function setBaseAvatarTemperatureModifier($baseAvatarTemperatureModifier) {
        $this->baseAvatarTemperatureModifier = $baseAvatarTemperatureModifier;
    }
}
