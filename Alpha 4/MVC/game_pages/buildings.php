<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/playerMapZoneController.php");
$zone = playerMapZoneController::getPlayerMapZoneController($avatar->getAvatarID());
if ($zone->getIsSpecialZone() !== false) {
    echo "<script>
            alert('You cannot access this page');
            window.location.href='/ingame.php?p=bo';
            </script>";
}
?>
<script src="/js/buildings_JS.js"></script>
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
        <a href="/ingame.php?p=c" class="menulink">Construct</a>
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
            <div class="bmenutab2" id="buildingtab">
                <a class="menulink2">Construct</a>
            </div>
            <div class="bmenutab" id="firetab">
                <a class="menulink" href="/ingame.php?p=bf">Firepit</a>
            </div>
            <div class="bmenutab" id="banktab">
                <a class="menulink" href="/ingame.php?p=bs">Storage</a>
            </div>
        </section>
        <section id="buildingswindow">
            <script>
                ajax_All(4,"none");
            </script>
            <div id="itemUsageBuildings">
                <?php
                if ($zone->getStorage() == 1){
                    echo "Buildings use items in the camp storage in this zone";
                } else {
                    echo "Buildings use items found on the ground in this zone currently";

                }
                ?>
            </div>
            <section id="zonebuildings">
            </section>
        </section>
    </section>
</section>