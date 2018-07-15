<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row standardWrapper justify-content-center align-items-center py-2">
    <div class="col-12 d-flex justify-content-end p-2">
        <button class="btn btn-danger btn-sm" onclick="changeView(2)">Close <i class="fas fa-ban"></i></button>
    </div>
    <div class="col-12 col-sm-11 d-flex flex-column justify-content-center p-2 zoneMapImageWrapper">

    </div>
    <div class="col-12 col-sm-11 d-flex flex-column justify-content-center align-items-center redColour font-size-3">
        <div class="directionButtonWrapper justify-content-center align-items-center d-flex clickableFlash m-1" onclick="moveDirection('n')"><i class="fas fa-caret-square-up font-size-4 red"></i></div>
    </div>
    <div class="col-12 col-sm-11 d-flex flex-row justify-content-center align-items-center redColour font-size-3">
        <div class="directionButtonWrapper justify-content-center align-items-center d-flex clickableFlash m-1" onclick="moveDirection('w')"><i class="fas fa-caret-square-left font-size-4"></i></div>
        <div class="directionButtonWrapper justify-content-center align-items-center d-flex clickableFlash m-1" onclick="moveDirection('s')"><i class="fas fa-caret-square-down font-size-4"></i></div>
        <div class="directionButtonWrapper justify-content-center align-items-center d-flex clickableFlash m-1" onclick="moveDirection('e')"><i class="fas fa-caret-square-right font-size-4"></i></div>
    </div>
    <div class="col-lg-7 col-md-8 col-11 zoneInformationBox borderAll grayBorder my-2">
        <div class="row p-2 justify-content-center">
            <div align="center" class="grayColour font-size-2x">No zone selected</div>
        </div>
    </div>
</div>