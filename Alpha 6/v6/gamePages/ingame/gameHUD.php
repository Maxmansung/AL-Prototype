<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row pb-3 justify-content-center">
    <div class="HUDSurvivalChances p-1 mt-md-3 font-size-2 font-weight-bold d-flex flex-column justify-content-center align-items-center">
        <div class="font-size-2 p-1 HUDSurvivalText" align="center"></div>
            <?php if ($map->getDayDuration() === "check"){
                echo '<div class="HUDDayEnd p-0" onclick="HUDReadyButton()"></div>';
            } else {
                echo '<div class="d-flex flex-column">
        <div class="col-12 HUDCurrentTime" align="right">20:12</div>
        <div class="col-12 font-size-1 grayColour pl-0 d-flex flex-wrap justify-content-end" ><span class="pr-1">Nightfall:</span><span class="HUDnightfall"></span></div></div>';
            }
            ?>
    </div>
</div>
<div class="row justify-content-center d-md-flex d-none">
    <div class="col-10 pb-4 mt-3 horizontalLine"></div>
</div>