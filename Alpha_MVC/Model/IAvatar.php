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
interface IAvatar {
    public function calculateAvatarSurvivableTemperature($zone);
    public function getAvatarID();
    public function setAvatarID($avatarID);
    public function getProfileID();
    public function setProfileID($profileID);
    public function getMapID();
    public function setMapID($mapID);
    public function getStamina();
    public function setStamina($stamina);
    public function getMaxStamina();
    public function setMaxStamina($maxStamina);
    public function getZoneID();
    public function setZoneID($zoneID);
    public function getInventory();
    public function setInventory($array);
    public function addItem($itemID);
    public function removeItem($itemID);
    public function getMaxInventorySlots();
    public function setMaxInventorySlots($maxInventorySlots);
    public function getPartyID();
    public function setPartyID($partyID);
    public function isReady();
    public function toggleReady();
    public function getZoneExploration();
    public function addRecentZone($zoneID, $zone, $timestamp);
    public function clearRecentZoneHistory();
    public function getAvatarTemperatureModifier();
    public function setAvatarTemperatureModifier($avatarTemperatureModifier);
    public function getAvatarSuvivableTemperature();
    public function getBaseAvatarTemperatureModifier();
    public function setBaseAvatarTemperatureModifier(
            $baseAvatarTemperatureModifier);
}
