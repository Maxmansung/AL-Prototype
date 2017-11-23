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
interface IMap {
    public function calculateBaseNightDuration();
    public function getMapID();
    public function setMapID($mapID);
    public function getName();
    public function setName($name);
    public function getMaxPlayerCount();
    public function setMaxPlayerCount($maxPlayerCount);
    public function getEdgeSize();
    public function setEdgeSize($edgeSize);
    public function getMaxPlayerStamina();
    public function setMaxPlayerStamina($maxPlayerStamina);
    public function getMaxPlayerInventorySlots();
    public function setMaxPlayerInventorySlots($maxPlayerInventorySlots);
    public function getAvatars();
    public function addAvatar($avatarID);
    public function removeAvatar($avatarID);
    public function getParties();
    public function addParty($partyID);
    public function removeParty($partyID);
    public function getZones();
    public function addZone($zoneID);
    public function removeZone($zoneID);
    public function getCurrentDay();
    public function setCurrentDay($currentDay);
    public function getDayDuration();
    public function setDayDuration($dayDuration);
    public function getBaseNightTemperature();
    public function setBaseNightTemperature($baseNightTemperature);
    public function getBaseSurvivableTemperature();
    public function setBaseSurvivableTemperature($baseSurvuvableTemperature);
    public function getAvatarSurvivableTemperatureModifier();
    public function setAvatarSurvivableTemperatureModifier($avatarSurvivableTemperatureModifier);
}
