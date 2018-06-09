<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row zoneImageWrapperPhone justify-content-center align-items-center">
    <div class="zoneImageInternalPhone">
        <div class="row justify-content-between p-0 m-0">
            <div class="col-1 d-flex justify-content-center align-items-center p-0 m-0">
                <div class="pl-2 m-0 clickable dirWest" onclick="moveDirection('w')">
                    <img class="mapArrowImage" src="/images/gamePage/Other/arrow-left.png">
                </div>
            </div>
            <div class="col-9">
                <div class="row justify-content-center align-items-center">
                    <div class="tempHolder">
                        <div class="p-0 m-0 clickable dirNorth" onclick="moveDirection('n')"><img class="mapArrowImage" src="/images/gamePage/Other/arrow-up.png"></div>
                    </div>
                </div>
                <div class="tempPaddingPhone row">

                </div>
                <div class="row justify-content-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <button class="btn d-flex btn-dark" onclick="getMapView()">Map</button>
                        <div class="d-flex zoneCoordWriting"></div>
                    </div>
                </div>
                <div class="temppaddingPhone2 row">

                </div>
                <div class="row">
                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                        <div class="zoneBuildingAvatarWrap d-flex flex-column align-items-center justify-content-center">
                            <div class="zoneBuildingsImageWrap">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex flex-row justify-content-center align-items-center pb-2">
                        <div class="zoneOtherAvatarWrapPhone" onclick="showPhoneAvatars()"></div>
                        <div class="zoneOtherAvatarWrapPhonePopup standardWrapper d-none">
                            <div class="row p-2 m-0 justify-content-end">
                                <button class="btn btn-danger btn-sm" onclick="hidePhoneAvatars()">Close <i class="fas fa-ban"></i></button>
                            </div>
                            <div class="row m-0 justify-content-center pt-1">
                                <div class="col-11 font-size-2 font-weight-bold" align="center">
                                    Select a player to interact with...
                                </div>
                            </div>
                            <div class="zoneOtherAvatarListWrapper row m-0 justify-content-center pt-3">
                                <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                                    <img src="/avatarimages/avatarIngame/avatarTemp.png" class="phoneAvatarListImage"><div class="font-size-2">Maxmansung</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex flex-row justify-content-center align-items-center">
                        <div class="zoneAvatarImageWrapPhone phoneHighlightBorder d-flex flex-row justify-content-center align-items-center" onclick="changeView(1)"></div>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="p-0 m-0 clickable dirSouth" onclick="moveDirection('s')"><img class="mapArrowImage" src="/images/gamePage/Other/arrow-down.png"></div>
                </div>
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center p-0 m-0">
                <div class="pr-2 m-0 clickable dirEast" onclick="moveDirection('e')"><img class="mapArrowImage" src="/images/gamePage/Other/arrow-right.png"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 whiteColour font-weight-bold font-size-3 mt-2" align="center">Zone Actions</div>
</div>
<div class="row">
    <div class="col-12 d-flex justify-content-center">
        <div class="zoneActionsWrap whiteColour d-flex flex-row flex-wrap justify-content-around align-items-start pb-2 px-2">
        </div>
    </div>
</div>

