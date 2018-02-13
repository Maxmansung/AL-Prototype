<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/shrineController.php");
$shrineZone = shrineController::findShrine($avatar->getZoneID());
if ($shrineZone !== false) {
    echo "<script>
            window.location.href='/ingame.php?p=s';
            </script>";
}
?>
<script src="/js/construction_JS.js"></script>
<section id="constructionWrap">
    <section class="horizontalWrap">
        <section class="verticalWrap" id="playerUpgrades">
            <div id="sleepingBagOverview">
                <div class="verticalWrap">
                    <div class="titleText">
                        Sleeping Bag
                    </div>
                    <div id="sleepingBagLevel">

                    </div>
                    <div class="horizontalWrap">
                        <div >
                            <img src="/images/sleepingIcon1.png" id="sleepingBagImage">
                        </div>
                        <div id="verticalDividingLine">

                        </div>
                        <div class="verticalWrap" >
                            <div id="sleepingBagUpgradeWriting">
                                Upgrade Cost:
                            </div>
                            <div class="horizontalWrap" id="sleepingBagUpgradeItems">

                            </div>
                            <button id="sleepingBagUpgradeButton" onclick="upgradeSleeping()">Upgrade</button>
                        </div>
                    </div>
                </div>
            </div>
            <section id="playerItemUse">
                <div class="verticalWrap" id="recipiesWrapper">
                    <div class="titleText">
                        Recipes
                    </div>
                    <div id="recipesUseWrap" class="useableTextWrap">
                    </div>
                </div>
                <div class="verticalWrap" id="consumablesWrapper">
                    <div class="titleText">
                        Consumables
                    </div>
                    <div id="itemsUseWrap" class="useableTextWrap">
                    </div>
                </div>
            </section>
            <div id="backpackWrap">
                <div class="titleText">
                    Backpack
                </div>
                <div id="backpackLevel">
                </div>
                <div class="horizontalWrap">
                    <div id="backpackHolderWrap">
                    </div>
                    <div id="verticalDividingLine">
                    </div>
                    <div class="verticalWrap" >
                        <div id="sleepingBagUpgradeWriting">
                            Upgrade Cost:
                        </div>
                        <div class="horizontalWrap" id="backpackUpgradeItems">
                        </div>
                        <button id="sleepingBagUpgradeButton" onclick="upgradeBackpack()">Upgrade</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="verticalWrap" id="constructionUpgrades">
            <div id="buildingsWrapper">
                <div  class="titleText">
                    Buildings
                </div>
                <div id="knownBuildingsList">

                </div>
            </div>
            <div class="horizontalLine"></div>
        </section>
    </section>
    <section class="horizontalWrap" id="itemHoldersWrap">
        <div id="storageBuildingWrap">
            <div  class="titleText">
                Zone Items
            </div>
            <div id="itemsListArrayWrap">
                <div id="itemListArrayTitle">
                    Type
                </div>
                <div id="itemListArray">

                </div>

            </div>
            <div class="horizontalWrap">
                <div class="storageTabSelection" id="storageTabBuilt" onclick="switchStorage(1)">
                    Chest
                </div>
                <div class="storageTabSelection" onclick="switchStorage(0)">
                    Ground
                </div>
            </div>
        </div>
        <div id="firepitOverview">
            <div  class="titleText">
                Firepit
            </div>
            <div id="firepitImageWrap" onclick="firepitBackpackView()">
                <div id="firepitBackpackWrap">

                </div>
                <div id="firepitInfoPopup">
                    Click to drop items
                </div>
                <img id="firepitImageType" src="/images/firepit2.png">
            </div>
            <div id="firepitFuel" class="buildingDetailsWriting">

            </div>
            <div id="firepitTempBonus" class="buildingDetailsWriting">

            </div>
        </div>
    </section>
</section>
<div id="disableScreenFirepit" class="disabledScreen" onclick="hideBackpackScreen()">

</div>
<div id="disableScreenResearch" class="disabledScreen"  onclick="hideResearchScreen()">
</div>
<script>
    ajax_All(0,"none",0)
</script>