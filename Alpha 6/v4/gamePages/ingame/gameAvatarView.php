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
    <div class="col-12 mb-3">
        <div class="row justify-content-center align-items-center zoneAvatarReseachBarWrapper">
        </div>
    </div>
    <div class="col-12 col-sm-6 d-none d-sm-flex d-md-none d-lg-flex justify-content-center">
        <img src="" class="zoneAvatarImage zoneAvatarPlayerImage">
    </div>
    <div class="backgroundImageAvatarSmallWrapper d-md-flex d-lg-none d-sm-none d-flex justify-content-center"><img src="" class="zoneAvatarImage zoneAvatarPlayerImage"></div>
    <div class="col-12 col-sm-6 col-md-12 col-lg-6 px-3">
        <div class="row mx-0 p-2 normalBorder">
            <div class="col-12 font-size-2x font-weight-bold mb-2" align="center">Improve Equipment</div>
            <div class="col-12 d-flex flex-column justify-content-center align-items-center zoneAvatarCurrentBackpack">
            </div>
            <div class="col-12 justify-content-center align-items-center d-flex">
                <img src="/images/gamePage/sleepingBag/directional.png" class="zoneCurrentEquipmentArrows">
            </div>
            <div class="col-12 d-flex flex-row justify-content-between align-items-center px-3 zoneAvatarUpgradeBackpack">
            </div>
            <div class="col-12 px-2 pt-4 mb-2 font-size-2">
                Choose a way to improve your equipment, some may help to keep you warmer whilst others may be better at holding your items. Will you choose based on preference or will the items you find force your hand?
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-12 col-lg-6 mt-2 px-3">
        <div class="row mx-0 p-2 normalBorder justify-content-center">
            <div class="col-12 font-size-2x font-weight-bold mb-2" align="center">Use Items</div>
            <div class="col-11 d-flex flex-column justify-content-start align-items-center zoneAvatarUseItems">
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-12 col-lg-6 mt-2 px-3">
        <div class="row mx-0 p-2 normalBorder justify-content-center">
            <div class="col-12 font-size-2x font-weight-bold mb-2" align="center">Recipes</div>
            <div class="col-11 d-flex flex-column justify-content-start align-items-center zoneAvatarMakeItems">
            </div>
        </div>
    </div>
</div>