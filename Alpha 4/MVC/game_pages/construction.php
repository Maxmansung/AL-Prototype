<script src="/js/construction_JS.js"></script>
<section id="gamemenu">
    <div class="menutab2" id="zoneActions">
        <a href="/ingame.php" class="menulink">Diary</a>
    </div>
    <div class="menutab2" id="maptab">
        <a href="/ingame.php?p=m" class="menulink">Map</a>
    </div>
    <div class="menutab2" id="playerstab">
        <a href="/ingame.php?p=p" class="menulink">Players</a>
    </div>
    <div class="menutab2" id="constructionTab">
        <a class="menulink">Construct</a>
    </div>
    <div class="menutab2" id="buildingtab">
        <a href="/ingame.php?p=bo" class="menulink">Buildings</a>
    </div>
</section>
<section id="constructionWrap">
    <section class="verticalWrap" id="playerUpgrades">
        <div id="sleepingBagOverview">
            <div class="verticalWrap">
                <div id="sleepingBagTitle" class="titleText">
                    Sleeping Bag
                </div>
                <div id="sleepingBagLevel">

                </div>
                <div class="horizonalWrap">
                    <div >
                        <img src="/images/sleepingIcon1.png" id="sleepingBagImage">
                    </div>
                    <div id="verticalDividingLine">

                    </div>
                    <div class="verticalWrap" >
                        <div id="sleepingBagUpgradeWriting">
                            Upgrade Cost:
                        </div>
                        <div class="horizonalWrap" id="sleepingBagUpgradeItems">

                        </div>
                        <button id="sleepingBagUpgradeButton" onclick="upgradeSleeping()">Upgrade</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="verticalWrap" id="constructionUpgrades">
        <div id="researchOverview" class="titleText">
            <div class="verticalWrap">
                <div id="researchOverviewTitle">
                    Research
                </div>
                <div id="researchLevel">

                </div>
            </div>
            <div class="horizonalWrap">
                <canvas id="myCanvas"></canvas>
                <div id="canvasLegend"></div>
            </div>
            <button onclick="researchButton()">Research</button>
        </div>
        <div class="horizontalLine"></div>
        <div id="buildingsWrapper">
            <div id="buildingsListTitle">
                Buildings
            </div>
            <div id="knownBuildingsList">

            </div>
        </div>
    </section>
</section>
<script>
    ajax_All(0,"none")
</script>