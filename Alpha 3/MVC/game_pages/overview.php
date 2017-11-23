<section id="gamemenu">
    <div class="menutab2" id="zoneActions">
        <a href="/ingame.php" class="menulink">Diary</a>
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
        <a class="menulink">Buildings</a>
    </div>
</section>
<section id="zonepagewrap">
    <section id="buildingspagewrap">
        <section id="buildingstabs">
            <div class="bmenutab2" id="fencetab">
                <a class="menulink2">Overview</a>
            </div>
            <div class="bmenutab" id="buildingtab">
                <a class="menulink" href="/ingame.php?p=bb">Construct</a>
            </div>
            <div class="bmenutab" id="firetab">
                <a class="menulink" href="/ingame.php?p=bf">Firepit</a>
            </div>
            <div class="bmenutab" id="banktab">
                <a class="menulink" href="/ingame.php?p=bs">Storage</a>
            </div>
        </section>
        <section id="buildingswindow">
            <section id="zoneOverview">
                <div id="zoneOverviewName"></div>
                <div id="zoneOverviewOwner"></div>
                <div id="zoneOverviewLock">
                    <div id="zoneOverviewLockTitle">Gate Lock</div>
                    <div class="verticalWrapCentre">
                        <canvas id="myCanvas"></canvas>
                        <div id="canvasLegend"></div>
                    </div>
                    <div id="zoneOverviewLockButton"></div>
                </div>
                <div id="zoneOverviewWrapHorizontal">
                    <div id="zoneOverviewBonuses">
                        <div id="zoneOverviewOtherBonuses"></div>
                    </div>
                    <div id="zoneOverviewInformation"></div>
                </div>
            </section>
        </section>
    </section>
    <script src="/js/overview_JS.js">
    </script>
    <script>
        ajax_All(13,"none");
    </script>
</section>