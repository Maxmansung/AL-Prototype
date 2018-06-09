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
        <div class="row justify-content-center align-items-center mb-0 pb-0">
            <div class="avatarPlayerName funkyFont font-size-5 mb-0 pb-0"></div>
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="row justify-content-center align-items-center">
            <div class="avatarPlayerPartyName grayColour font-size-2x mt-0 pt-0"></div>
        </div>
    </div>
    <div class="col-11 d-flex d-sm-none d-md-flex d-lg-none flex-row justify-content-center align-items-center zoneAvatarOtherButtons mb-2">
        These are the buttons to Message a player and Request to join player
    </div>
    <div class="col-11 col-sm-6 d-none d-sm-flex d-md-none d-lg-flex flex-column justify-content-center align-items-center">
        <img src="/avatarimages/avatarIngame/avatarTemp.png" class="zoneAvatarImage zoneAvatarOtherImage">
        <div class="col-11 d-flex flex-row justify-content-center align-items-center zoneAvatarOtherButtons mb-2">
            These are the buttons to Message a player and Request to join player
        </div>
    </div>
    <div class="backgroundImageAvatarSmallWrapper d-md-flex d-lg-none d-sm-none d-flex justify-content-center"><img src="/avatarimages/avatarIngame/avatarTemp.png" class="zoneAvatarImage zoneAvatarOtherImage"></div>
    <div class="col-11 col-sm-6 col-md-11 col-lg-6 px-3">
        <div class="row mx-0 p-2 normalBorder justify-content-center">
            <div class="col-11 standardWrapperTitle font-weight-bold pb-1 mb-2" align="center">Teach Research</div>
            <div class="col-11 font-size-2 my-2" align="center">Here you can teach another player the buildings you know, however it's a pretty stressful experience and takes <b>2 stamina</b> each time</div>
            <div class="col-11 zoneOtherAvatarResearch">
            </div>
        </div>
    </div>
    <div class="col-11 px-3 my-2">
        <div class="row normalBorder mx-0 p-2 justify-content-center">
        These are all the messages exchanged between yourself and another player
        </div>
    </div>
</div>