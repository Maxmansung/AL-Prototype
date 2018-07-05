<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row zoneImageWrapper justify-content-center align-items-center">
    <div class="zoneImageInternal">
        <div class="row">
            <div class="col-1 d-flex justify-content-center align-items-center">
                    <div class="pl-2 m-0 clickable dirWest" onclick="moveDirection('w')">
                        <img class="mapArrowImage" src="/images/gamePage/Other/arrow-left.png">
                    </div>
            </div>
            <div class="col-10">
                <div class="row justify-content-center align-items-center p-0 m-0">
                    <div class="tempHolder">
                    <div class="p-0 m-0 clickable dirNorth" onclick="moveDirection('n')"><img class="mapArrowImage" src="/images/gamePage/Other/arrow-up.png"></div>
                    </div>
                </div>
                <div class="row justify-content-end">
                        <div class="d-flex flex-column justify-content-center align-items-center zoneMapPadding">
                            <button class="btn d-flex btn-dark" onclick="changeView(5)">Map</button>
                            <div class="d-flex zoneCoordWriting"></div>
                        </div>
                </div>
                <div class="zoneBuildingLocks row justify-content-end align-items-center flex-column">
                </div>
                <div class="row">
                    <div class="col-12 d-flex flex-row justify-content-between align-items-end">
                        <div class=""></div>
                        <div class="zoneBuildingAvatarWrap d-flex flex-column align-items-center justify-content-center">
                            <div class="zoneBuildingsImageWrap" data-html="true" data-toggle="popover" data-placement="top" title="Buildings" data-content="None">
                            </div>
                            <div class="zoneAvatarImageWrap clickableTransparent" data-toggle="popover" data-placement="top" title="Avatar" data-content="Here you can use items, upgrade your equipment and research new buildings."  onclick="changeView(1)"></div>
                        </div>
                        <div class="zoneOtherAvatarWrap d-flex flex-row align-content-around justify-content-around flex-wrap align-items mr-2">
                        </div>
                    </div>
                </div>
                <div class="tempPadding2 row">

                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="zoneActionsWrap blackColour blackBorder d-flex flex-row justify-content-start align-items-start">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="p-0 m-0 clickable dirSouth" onclick="moveDirection('s')"><img class="mapArrowImage" src="/images/gamePage/Other/arrow-down.png"></div>
                </div>
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center">
                <div class="pr-2 m-0 clickable dirEast" onclick="moveDirection('e')"><img class="mapArrowImage" src="/images/gamePage/Other/arrow-right.png"></div>
            </div>
        </div>
    </div>
</div>
