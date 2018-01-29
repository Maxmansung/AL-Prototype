<script src="/js/mapZone_JS.js"></script>
<section id="mappagewrap">
    <section id="movementLog">
        <div id="movementLogTitle">
            Zone Actions
        </div>
        <div id="movementLogActions">

        </div>
    </section>
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
    <div id="zoneInfoWrapper">
        <section id="zoneinformation">
        </section>
        <div class="horizontalWrap" id="zoneActionsWrap">
            <div id="destroyBiomeButton"><img src="/images/searchIcon.png" id="destroyBiomeImage" onclick="searchZone()"><span class="imagetext"><strong>Search zone</strong><br>Costs 1 stamina</span></div>
            <div id="destroyBiomeButton"><img src="/images/explosionButton.png" id="destroyBiomeImage" onclick="destroyBiome()"><span class="imagetext"><strong>Destroy zone</strong><br>Costs 5 stamina</span></div>
        </div>
        <section id="grounditems">
        </section>
    </div>
    <section id="backpackwrap">
        <span class="titleText">
            Backpack
        </span>
        <section id="backpack">
        </section>
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
<script>
    ajax_All(19,"none",7);
</script>