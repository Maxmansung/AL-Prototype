<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class HUDView
{
    protected $playerStamina;
    protected $playerMaxStamina;
    protected $currentDay;
    protected $dayEnding;
    protected $nightTemp;
    protected $calcSurvTemp;
    protected $maxInventorySlots;
    protected $zoneID;
    protected $readyStatus;
    protected $avatarID;
    protected $clock;
    protected $mapName;
    protected $tempBaseSurvival;
    protected $tempItemsBonus;
    protected $tempZoneMod;
    protected $tempBuildings;
    protected $tempFirepit;
    protected $tempBlessings;
    protected $mapType;
    protected $statusArray;
    protected $survivalWarning;



    public function __construct($avatarID)
    {
        $avatarModel = new avatarController($avatarID);
        $mapModel = new mapController($avatarModel->getMapID());
        $totalSurvival = buildingLevels::getModifiedViewSurviveTemp($avatarID);
        $zone = new zoneController($avatarModel->getZoneID());
        $biome = new biomeTypeController($zone->getBiomeType());
        $this->playerStamina = $avatarModel->getStamina();
        $this->playerMaxStamina = $avatarModel->getMaxStamina();
        $this->currentDay = $mapModel->getCurrentDay();
        $this->dayEnding = HUDController::getDayEndTime();
        $this->clock = date("H:i",time());
        $this->nightTemp = $mapModel->getBaseNightTemperature()-$biome->getTemperatureMod();
        $this->calcSurvTemp = $totalSurvival;
        $this->maxInventorySlots = $avatarModel->getMaxInventorySlots();
        $this->zoneID = $avatarModel->getZoneID();
        $this->readyStatus = $avatarModel->getReady();
        $this->avatarID = $avatarModel->getAvatarID();
        $this->mapName = $mapModel->getName();
        $this->tempBaseSurvival = buildingLevels::sleepingBagLevelBonus($avatarModel->getTempModLevel());
        $this->tempItemsBonus = avatarController::getItemBonuses($avatarModel->getMapID(),$avatarModel->getAvatarID());
        $this->tempBuildings = buildingLevels::buildingsTempIncrease($avatarModel->getAvatarID());
        $this->tempFirepit = buildingController::getFirepitBonus($avatarModel->getZoneID());
        $party = new partyController($avatarModel->getPartyID());
        $this->tempBlessings = $party->getTempBonus()+$avatarModel->getAvatarSurvivableTemp();
        $zone = new zoneController($avatarModel->getZoneID());
        $biome = new biomeTypeController($zone->getBiomeType());
        $this->tempZoneMod = $biome->getTemperatureMod();
        $this->mapType = $mapModel->getDayDuration();
        $this->statusArray = statusView::getStatusView($avatarModel->getStatusArray());
        $this->survivalWarning = dayEndingFunctions::testPlayerSurvival($avatarModel,$mapModel->getBaseNightTemperature());
    }

    function returnVars(){
        return get_object_vars($this);
    }

}