<script src="/js/zoneActions_JS.js"></script>
<section id="gamemenu">
    <div class="menutab2" id="zoneActions">
        <a class="menulink">Diary</a>
    </div>
    <div class="menutab2" id="avatarTab">
        <a href="/ingame.php?p=a" class="menulink">Personal</a>
    </div>
    <div class="menutab2" id="maptab">
        <a href="/ingame.php?p=m" class="menulink">Map</a>
    </div>
    <div class="menutab2" id="playerstab">
        <a href="/ingame.php?p=p" class="menulink">Players</a>
    </div>
    <div class="menutab2" id="buildingtab">
        <a href="/ingame.php?p=bo" class="menulink">Buildings</a>
</section>
<section id="zoneActionsPageWrap">
    <section class="horizonalWrap">
        <section class="verticalWrapTempDisplay">
            Night Temperature
            <section class="temperatureDisplay">
                <span id="zoneTempDisplay"></span>&degC
            </section>
        </section>
        <section class="verticalWrap">
            <section class="dayShownTitle" id="currentDayDiary">
                Day
                <div id="currentDayInput">

                </div>
            </section>
            <section class="dayShownTitle" id="selectDayDiary">
                View day:
                <select id="daySelectionDrop" name="selectDay">
                    <option value="ERROR">ERROR</option>
                </select>
                <button id="selectDayDiaryButton" onclick="getNewDay()">Find</button>
            </section>
        </section>
        <section class="verticalWrapTempDisplay">
            Survivable Temperature
            <section class="temperatureDisplay">
                <span id="playerTempDisplay"></span>&degC
            </section>
        </section>
    </section>
    <section id="movementLogOverview">
        <div id="movementLogOverviewTitle">
            Zone Diary
        </div>
        <div id="movementLogOverviewActions">

        </div>
    </section>
</section>
<script>
    ajax_All(12,"current");
</script>