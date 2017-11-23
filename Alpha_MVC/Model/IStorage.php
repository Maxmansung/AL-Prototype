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
interface IStorage {
    public function calculateStorageValues();
    public function getStorageID();
    public function setStorageID($storageID);
    public function getMapID();
    public function setMapID($mapID);
    public function getZoneID();
    public function setZoneID($zoneID);
    public function getOwningParty();
    public function setOwningParty($partyID);
    public function getItems();
    public function addItem($itemID);
    public function removeItem($itemID);
    public function getMaximumCapacity();
    public function setMaximumCapacity($maximumCapacity);
}
