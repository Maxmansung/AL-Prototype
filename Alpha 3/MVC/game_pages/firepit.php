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
            <div class="bmenutab2" id="firetab">
                <a class="menulink2">Firepit</a>
            </div>
            <div class="bmenutab" id="banktab">
                <a class="menulink" href="/ingame.php?p=bs">Storage</a>
            </div>
        </section>
        <section id="buildingswindow">
            <section id="zonebuildings">
                <section id="movementLog">
                    <div id="movementLogTitle">
                        Firepit Actions
                    </div>
                    <div id="movementLogActions">

                    </div>
                </section>
                <script src="/js/firepit_JS.js">
                </script>
                <script>
                    ajax_All(10,"none");
                </script>
                <section id="firepitwrapper">
                    <section id="backpackwrap">
                        <div id="backpackwrapText">
                        --Drop items into the fire--
                        </div>
                        <section id="backpack">
                        </section>
                    </section>
                    <section id="firepittext">
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>