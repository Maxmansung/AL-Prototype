<script src="/js/avatar_JS.js"></script>
<section id="gamemenu">
    <div class="menutab2" id="zoneActions">
        <a href="/ingame.php" class="menulink">Diary</a>
    </div>
    <div class="menutab2" id="avatarTab">
        <a class="menulink">Personal</a>
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
<section id="avatarPageWrap">
    <div id="avatarOverview">
        <div class="verticalWrap">
            <div id="avatarOverviewTitle" class="titleText">
                Overview
            </div>
            <div class="horizonalWrap" id="avatarOverviewHorizontal">
                <div id="avatarOverviewImage">
                    Avatar Image
                </div>
                <div id="avatarOverviewTemp">
                    Player temp
                </div>
                <div id="backpackwrap">
                    Backpack
                    <div id="backpack">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="horizonalWrap" id="avatarPageSpacing">
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
        <div class="verticalWrap" id="avatarPageSpacing">
            <div id="researchOverview" class="titleText">
                <div id="researchOverviewTitle">
                    Research
                </div>
                <div id="researchLevel">

                </div>
                <div class="horizonalWrap">
                    <canvas id="myCanvas"></canvas>
                    <div id="canvasLegend"></div>
                </div>
                <button onclick="researchButton()">Research</button>
            </div>
            <section id="playeritemuse">
                <div id="createItemsTitle" class="titleText">
                     Actions
                </div>
                <div id="dropdownwrap">
                    <span id="useitemspan"></span>
                    <select id="itemactions">
                        <option value="none">Error</option>
                    </select>
                    <span id="useitemspan"></span>
                    <button id="actionbutton" onclick="recipeIDValue()">Action</button>
                </div>
            </section>
        </div>
    </div>
</section>
<script>
    ajax_All(0,"none");
</script>