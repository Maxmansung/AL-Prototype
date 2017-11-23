<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/zoneController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/biomeTypeController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/buildingItemController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/profileController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/partyController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/deathScreenController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/newMapJoinController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/nameGeneratorController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/shrineController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/chatlogWorldController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/data/buildingLevels.php");
class constructionView
{
    protected $buildings;
    protected $researchLevel;
    protected $researchCost;
    protected $researchStamina;
    protected $upgradeCost;

    function __construct($avatarID)
    {
        $avatar = new avatarController($avatarID);
        $this->buildings = buildingItemController::checkItems($avatarID);
        $this->modifierLevel = $avatar->getTempModLevel();
        $this->researchLevel = $avatar->getResearchStatsLevel();
        $this->researchStamina = $avatar->getResearchStatsStamina();
        $this->researchCost = buildingLevels::researchStaminaLevels($this->researchLevel);
        $this->upgradeCost = $this->upgradeItems();
    }

    function returnVars(){
        return get_object_vars($this);
    }

    private function upgradeItems(){
        $upgradeArray = buildingLevels::sleepingBagUpgradeCost($this->modifierLevel);
        $itemsArray = [];
        foreach ($upgradeArray as $item => $count) {
            $itemObject = new itemController("");
            $itemObject->createBlankItem($item);
            for ($x = 0; $x < $count; $x++) {
                $itemsArray[$itemObject->getIdentity() . $x] = $itemObject->returnVars();
            }
        }
        return $itemsArray;
    }
}