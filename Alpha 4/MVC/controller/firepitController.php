<?php
class firepitController
{

    protected $currentFuel;
    protected $temperatureIncrease;
    protected $buildingID;

    function __toString()
    {
        $output = $this->currentFuel;
        $output .= '/ ' . $this->temperatureIncrease;
        $output .= '/ ' . $this->buildingID;
        return $output;
    }

    function getCurrentFuel(){
        return $this->currentFuel;
    }

    function getTemperatureIncrease(){
        return $this->temperatureIncrease;
    }

    function getBuildingID(){
        return $this->buildingID;
    }

    function __construct($buildingController)
    {
        $this->currentFuel = $buildingController->getFuelRemaining();
        $this->temperatureIncrease = $this->calculateTemperatureIncrease($buildingController->getFuelRemaining());
        $this->buildingID = $buildingController->getBuildingID();
    }

    private function calculateTemperatureIncrease($firepitFuel){
        return floor(3*(sqrt($firepitFuel)));
    }

    public function returnVars(){
        return get_object_vars($this);
    }

}