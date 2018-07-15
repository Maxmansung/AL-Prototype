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
    <div class="col-12 grayColour font-size-2x zoneShrineGodType" align="center"></div>
    <div class="col-12 funkyFont font-size-5 zoneShrineGodName" align="center"></div>
    <div class="col-12 d-flex justify-content-center align-items-center">
        <img src="/images/gamePage/shrines/ice_shrine.png" class="zoneShrineImage">
    </div>
    <div class="col-11 col-sm-8 col-md-10 col-lg-8 font-size-2 pt-2 zoneShrineDetails" align="center"></div>
    <div class="col-12 d-flex justify-content-center my-2 zoneShrineWorshipButton">
    </div>
    <div class="col-12 grayColour font-size-2 zoneShrineWorshipCost" align="center"></div>
    <div class="col-11 py-4">
        <div class="row align-items-center justify-content-center">
            <div class="col-8 standardWrapperTitle mb-1" align="center">
                Most Favoured
            </div>
        </div>
        <div class="row borderAll grayBorder zoneShrineWorshipList">
        </div>
    </div>
</div>