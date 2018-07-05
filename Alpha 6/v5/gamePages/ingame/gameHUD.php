<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row">
    <div class="col-8 p-2">
        <div class="col-12 pl-1">Day <?php echo $map->getCurrentDay() ?></div>
        <div class="font-size-2 pl-1 col-12"><?php echo $map->getName() ?></div>
    </div>
    <div class="col-4 p-2">
        <?php if ($map->getDayDuration() === "check"){
            echo '<div class="col-12 d-flex justify-content-center align-items-center HUDDayEnd" onclick="HUDReadyButton()"></div>';
} else {
            echo '
        <div class="col-12 HUDCurrentTime" align="right">20:12</div>
        <div class="col-12 font-size-1 grayColour pl-0 d-flex flex-wrap justify-content-end" ><span class="pr-1">Nightfall:</span><span class="HUDnightfall"></span></div>';
}
?>
    </div>
</div>
<div class="row pb-2">
    <div class="col-12 d-flex flex-row justify-content-center"><div class="pr-2">Status</div><div class="HUDstatuses standardWrapper col-7 justify-content-start align-items-center d-flex flex-row px-1 flex-wrap"></div><div class="col-1"></div></div>
</div>
<div class="row">
    <div class="col-4 col-md-6 d-flex justify-content-center flex-row flex-md-column font-size-2 pr-0">
        <div class="font-weight-bold pr-1">Survivable:</div>
        <div class="redColour" align="center"><span class="HUDplayerTemp"></span><span>&#176C</span></div>
    </div>
    <div class="col-4 d-md-none d-flex justify-content-center flex-column font-size-2">
        <div class="font-weight-bold" align="center">Night</div>
        <div class="font-size-2x font-weight-bold" align="center"><span class="HUDLandTemp"></span><span>&#176C</span></div>
    </div>
    <div class="col-4 col-md-6 d-flex justify-content-center flex-row flex-md-column font-size-2 pl-0">
        <div class="font-weight-bold pr-1">Stamina:</div>
        <div align="center"><span class="HUDCurrentStamina"></span><span>/</span><span class="HUDMaxStamina"></span></div>
    </div>
</div>
<div class="row d-none d-md-flex pt-2">
    <div class="col-6 d-flex flex-row">
        <img class="thermometerImage" src="/images/gamePage/Thermometer/thermometer5.png">
        <div class="d-flex flex-column">
            <div class="font-size-2" align="right">Nightfall</div>
            <div class="font-weight-bold" align="right"><span class="HUDLandTemp"></span><span>&#176C</span></div>
        </div>
    </div>
    <div class="col-6">
        <div class="col-12">Backpack</div>
        <div class="backpackWrapper d-flex flex-row flex-wrap pt-1 pr-1 pb-2 pl-2 col-12">
        </div>
    </div>
</div>