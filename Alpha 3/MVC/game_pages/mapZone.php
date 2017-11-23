<script src="/js/mapZone_JS.js"></script>
<section id="gamemenu">
    <div class="menutab2" id="zoneActions">
        <a href="/ingame.php" class="menulink">Diary</a>
    </div>
    <div class="menutab2" id="avatarTab">
        <a href="/ingame.php?p=a" class="menulink">Personal</a>
    </div>
    <div class="menutab2" id="maptab">
        <a class="menulink">Map</a>
    </div>
    <div class="menutab2" id="playerstab">
        <a href="/ingame.php?p=p" class="menulink">Players</a>
    </div>
    <div class="menutab2" id="buildingtab">
        <a href="/ingame.php?p=bo" class="menulink">Buildings</a>
    </div>
</section>
<section id="mappagewrap">
    <section id="movementLog">
        <div id="movementLogTitle">
            Zone Actions
        </div>
        <div id="movementLogActions">

        </div>
    </section>
    <section class="horizonalWrap">
        <section class="verticalWrapCentre" id="mapZoneLeftWrap">
            <section id="mapwrapper">
                <img src="/images/arrowup.png" class="directionbutton" id="butnorth" onclick="movedirection('n')">
                <section id="wrapperEW">
                    <img src="/images/arrowleft.png" class="directionbutton" id="butwest" onclick="movedirection('w')">
                        <section id="start">

                        </section>
                    <img src="/images/arrowright.png" class="directionbutton" id="buteast" onclick="movedirection('e')">
                </section>
                <img src="/images/arrowdown.png" class="directionbutton" id="butsouth" onclick="movedirection('s')">
            </section>
            <section id="infobox">
                    <div id="zonelocation">
                    </div>
                    <div id="environment">
                    </div>
                    <div id="mapItems">
                    </div>
                    <div id="players">
                    </div>
            </section>
        </section>
        <section id="mapZoneInfo">
            <div id="zoneInfoWrapper">
                <section id="zoneinformation">
                </section>
            </div>
            <section id="playerActionsWrap">
                <section id="backpackwrap">
                    <span id="titleText">
                        Backpack
                    </span>
                    <section id="backpack">
                    </section>
                </section>
                <button id="searchbutton" onclick="searchZone()">Search Zone</button>
            </section>
            <section id="destroyBiome">
                <div class="verticalWrap">
                <span id="titleText">
                    Destroy the Biome
                </span>
                <span id="explinationText">
                    By releasing a large amount of stamina at once you can set off a small explosion destroying the top level of the zone and half the items yet to be found
                </span>
                </div>
                <div id="destroyBiomeButton"><img src="/images/explosionButton.png" id="destroyBiomeImage" onclick="destroyBiome()"><span class="imagetext">Costs 5 stamina</span></div>
            </section>
            <section id="grounditemswrap">
                    <span id="titleText">
                        Ground
                    </span>
                <section id="grounditems">
                </section>
            </section>
        </section>
    </section>
</section>
<script>
    ajax_All(19,"none");
</script>