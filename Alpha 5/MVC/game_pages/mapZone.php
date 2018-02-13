<script src="/js/mapZone_JS.js"></script>
<section id="mappagewrap">
    <section id="movementLog">
        <div id="movementLogTitle">
            Zone Actions
        </div>
        <div id="movementLogActions">

        </div>
    </section>
    <section id="infobox">
        <div id="zonelocation">
        </div>
    </section>
    <div id="zoneDirectionsWrapper">
        <div class="directionButtonWrap"><img src="/images/arrowup.png" class="directionbutton" id="butnorth" onclick="movedirection('n')"><span class="imagetext"><strong>Move North</strong><br>Costs 1 stamina</span></div>
        <section id="wrapperEW">
            <div class="directionButtonWrap"><img src="/images/arrowleft.png" class="directionbutton" id="butwest" onclick="movedirection('w')"><span class="imagetext"><strong>Move West</strong><br>Costs 1 stamina</span></div>
            <div id="zoneInfoWrapper">
                <div id="zonePlayersWrapper">

                </div>
                <div id="miniMapWrapper">

                </div>
                <div id="mapButtonWrapper">
                    <img src="/images/mapButton.png" class="mapActionButton" onclick="openMapImage()">
                    <span class="imagetext"><strong>View Map</strong></span>
                    <div id="mapCoordinates">WRITING</div>
                </div>
                <div id="actionButtonsWrapper">
                    <div id="actionButtonsBackground">
                        <div class="titleText">Actions</div>
                        <div class="horizontalWrap">
                            <div class="mapActionButton" id="actionSearchButton">
                            </div>
                            <div class="mapActionButton" id="actionExplosionButton">
                            </div>
                            <div class="mapActionButton" id="actionShrineButton">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section id="mapwrapper">
                <div id="mapButtonWrapper2">
                    <img src="/images/mapButton.png" class="mapActionButton" onclick="hideMapWrapper()">
                    <span class="imagetext"><strong>View Zone</strong></span>
                </div>
                <section id="start">
                </section>
            </section>
            <div class="directionButtonWrap"><img src="/images/arrowright.png" class="directionbutton" id="buteast" onclick="movedirection('e')"><span class="imagetext"><strong>Move East</strong><br>Costs 1 stamina</span></div>
        </section>
        <div class="directionButtonWrap"><img src="/images/arrowdown.png" class="directionbutton" id="butsouth" onclick="movedirection('s')"><span class="imagetext"><strong>Move South</strong><br>Costs 1 stamina</span></div>
    </div>
    <section class="horizontalWrap">
        <section class="verticalWrap">
            <section class="itemContainerWrap">
                <div class="titleTextMap">
                    Backpack
                </div>
                <section id="backpack">
                </section>
            </section>
            <section class="itemContainerWrap">
                <div class="titleTextMap">
                    Ground
                </div>
                <section id="grounditems">
                </section>
            </section>
        </section>
    </section>
</section>
<script>
    ajax_All(19,"none",7);
</script>