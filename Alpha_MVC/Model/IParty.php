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
interface IParty {
    public function calculatePartyValues();
    public function getPartyID();
    public function setPartyID($partyID);
    public function getMapID();
    public function setMapID($mapID);
    public function getMembers();
    public function addMember($avatarID);
    public function removeMember($avatarID);
    public function getPendingRequests();
    public function addPendingRequest($requestedPlayerID, $groupMemberID);
    public function addRequestedPlayerVote($requestedPlayerID, $groupMemberID, $isAccepted);
    public function resolvePendingRequest($requestedPlayerID, $isAccepted);
    public function getPendingBans();
    public function addPendingBan($banPlayerID, $groupMemberID);
    public function addBanPlayerVote($banPlayerID, $groupMemberID, $isBanned);
    public function resolvePendingBan($banPlayerID, $isBanned);
    public function getClaimedZones();
    public function addClaimedZone($zoneID);
    public function removeClaimedZone($zoneID);
    public function getProtectedZones();
    public function addProtectedZone($zoneID);
    public function removeProtectedZone($zoneID);
}
