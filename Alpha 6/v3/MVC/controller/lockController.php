<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
class lockController
{

    protected $maximum;
    protected $current;
    protected $type;
    protected $access;
    protected $buildingIcon;
    protected $buildingID;

    function getMaximum(){
        return $this->maximum;
    }

    function getCurrent(){
        return $this->current;
    }

    function getType(){
        return $this->type;
    }

    function getAccess(){
        return $this->access;
    }

    function getBuildingIcon(){
        return $this->buildingIcon;
    }

    function getBuildingID(){
        return $this->buildingID;
    }

    function __construct($controller, $partyID)
    {
        if ($controller->getBuildingID() !== "") {
            $this->maximum = $controller->getFuelBuilding();
            $this->current = $controller->getFuelRemaining();
            $this->type = $controller->getName();
            $this->buildingIcon = $controller->getIcon();
            $this->buildingID = $controller->getBuildingTemplateID();
            $zone = new zoneController($controller->getZoneID());
            if ($zone->getControllingParty() === $partyID){
                $this->access = true;
            } else {
                $this->access = false;
            }
        }
    }


        function returnVars()
        {
            return get_object_vars($this);
        }
}