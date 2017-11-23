<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/playerMapZoneController.php");
$zone = playerMapZoneController::getPlayerMapZoneController($avatar->getAvatarID());
if ($zone->getCanEnterZone() != true){
    echo "<script>
            alert('This zone has been locked by another party');
            window.location.href='/ingame.php?p=bo';
            </script>";
}
?>
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
            <div class="bmenutab" id="fencetab">
                <a class="menulink" href="/ingame.php?p=bo">Overview</a>
            </div>
            <div class="bmenutab" id="buildingtab">
                <a class="menulink" href="/ingame.php?p=bb">Construct</a>
            </div>
            <div class="bmenutab" id="firetab">
                <a class="menulink" href="/ingame.php?p=bf">Firepit</a>
            </div>
            <div class="bmenutab2" id="banktab">
                <a class="menulink2">Storage</a>
            </div>
        </section>
        <section id="buildingswindow">
            <section id="movementLog">
                <div id="movementLogTitle">
                    Storage Actions
                </div>
                <div id="movementLogActions">

                </div>
            </section>
            <script src="/js/storage_JS.js"></script>
            <div id="storageTitle">Storage Chest</div>
            <div id="storageLevel"></div>
            <div id="storageLockedWriting"></div>
            <section id="storageLock">
            </section>
            <section id="backpackWrapStorage">
                Backpack
                <section id="backpackStorage">
                </section>
            </section>
            <section id="upgradeStorageWrap">
                <section id="upgradeStorageWritingWrap">
                    <section id="upgradeStorageWriting">
                        Upgrade Cost:
                    </section>
                    <section id="upgradeStorageCost">
                        (Items)
                    </section>
                </section>
                <button id="upgradeStorageButton" onclick="upgradeStorage()">Upgrade</button>
            </section>
            <section id="storageWrap">
                <section id="storageWrapWriting">
                </section>
                <section id="storage">
                    <script>
                        ajax_All(15, "none");
                    </script>
                </section>
            </section>
        </section>
    </section>
</section>