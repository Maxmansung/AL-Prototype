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
        <div id="backpackWrap">
            <div class="titleText">
                Backpack
            </div>
            <div id="backpackWrapBorder">
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
        </div>
        <section id="playerItemUse">
            <div class="titleText">
                Actions
            </div>
            <div id="mainDropdownWrap">
                <div class="dropdownwrap2">
                    <select id="itemActions" class="itemActionDrop" >
                        <option value="none">Error</option>
                    </select>
                    <button id="useRecipeButton" onclick="recipeIDValue()">Combine</button>
                </div>
                <div class="dropdownwrap2">
                    <select id="useActions" class="itemActionDrop" >
                        <option value="none">Error</option>
                    </select>
                    <button id="useItemButton" onclick="recipeIDValueUse()">Use</button>
                </div>
            </div>
        </section>
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
    </section>
</section>
<div id="disableScreenFirepit" onclick="hideBackpackScreen()">

</div>
<script>
    ajax_All(0,"none",0)
</script>