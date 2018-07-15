<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row py-2 px-sm-3 px-1 justify-content-center align-items-center d-flex flex-wrap blackColour">
    <div class="col-6 col-md-4 my-1 d-flex order-md-1 order-1 justify-content-center">
        <div class="HUDstaminaBar HUDWrapperBorder d-flex flex-column justify-content-center font-size-2"><div class="font-weight-bold" align="center">STAMINA</div><div align="center"><span class="HUDCurrentStamina"></span><span>/</span><span class="HUDMaxStamina"></span></div></div>
    </div>
    <div class="col-6 col-md-4 my-1 d-flex order-md-2 order-3 justify-content-center font-size-2">
        <div class="HUDTemperatureBar HUDWrapperBorder d-flex flex-column justify-content-center align-items-center">
            <div class="font-size-2 font-weight-bold blackColour" align="center">NIGHT (<span class="HUDLandTemp"></span><span>&#176C</span>)</div>
            <div class="temperatureLine"></div>
            <div class="d-flex justify-content-center"><img src="/images/gamePage/Thermometer/tempArrowDown.png"></div>
            <div class="temperatureLabels d-flex flex-row font-size-1 justify-content-center align-items-center">
                <div class="smallTemperatureLine d-sm-block d-none"></div>
                <div class="font-weight-bold d-sm-block d-none">I</div>
                <div class="smallTemperatureLine"></div>
                <div class="font-weight-bold thermometerTemp0"></div>
                <div class="smallTemperatureLine"></div>
                <div class="font-weight-bold">I</div>
                <div class="smallTemperatureLine"></div>
                <div class="font-weight-bold thermometerTemp1"></div>
                <div class="smallTemperatureLine"></div>
                <div class="font-weight-bold">I</div>
                <div class="smallTemperatureLine"></div>
                <div class="font-weight-bold thermometerTemp2"></div>
                <div class="smallTemperatureLine"></div>
                <div class="font-weight-bold d-sm-block d-none">I</div>
                <div class="smallTemperatureLine d-sm-block d-none"></div>
            </div>
            <div class="temperatureSurvivalArrow d-flex"><img src="/images/gamePage/Thermometer/tempArrowUp.png"></div>
            <div class="temperatureLine"></div>
            <div class="font-size-2 font-weight-bold blackColour" align="center">SURVIVAL (<span class="HUDplayerTemp"></span><span>&#176C</span>)</div>
        </div>
    </div>
    <div class="col-6 col-md-4 my-1 d-flex order-md-3 order-2 justify-content-center">
        <div class="HUDStatusWrapper HUDWrapperBorder whiteBackground d-flex flex-column justify-content-start align-items-center">
            <div class="font-size-2 font-weight-bold" align="center">STATUSES</div>
            <div class="HUDstatuses  justify-content-start align-items-center d-flex flex-row px-1 flex-wrap"></div>
        </div>
    </div>
</div>