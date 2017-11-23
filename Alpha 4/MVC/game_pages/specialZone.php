<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/playerMapZoneController.php");
$zone = playerMapZoneController::getPlayerMapZoneController($avatar->getAvatarID());
if ($zone->getIsSpecialZone() === false){
    echo "<script>
            window.location.href='/ingame.php?p=bo';
            </script>";
}
$shrine = new shrineController($zone->getIsSpecialZone());
?>
<script src="/js/overview_JS.js"></script>
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
        <section class="verticalWrap">
            <section id="movementLog">
                <div id="movementLogTitle">
                    Shrine Actions
                </div>
                <div id="movementLogActions">

                </div>
            </section>
            <div id="zoneOverview">
                <section id="zoneOverviewName">
                    <?php
                    echo $shrine->getShrineName();
                    ?>
                </section>
                <div class="horizonalWrap">
                    <div class="verticalWrap" id="specialZoneDescription">
                        <div id="zoneOverviewDescription" align="center">
                            <?php
                            echo $shrine->getDescription();
                            ?>
                        </div>
                        <div class="specialBuildingImageWrap">
                            <?php
                            echo "<img src='/images/".$shrine->getShrineIcon()."' class='specialBuildingImage'>"
                            ?>
                        </div>
                            <?php
                            echo '<button class="performSpecialAction" onclick="performSpecialAction(this.id)" id="'.$shrine->getShrineID().'">
                                Worship
                            </button>'
                            ?>
                            <div class="descriptiveText" align="center">
                                <?php
                                echo $shrine->getWorshipDescription();
                                ?>
                            </div>
                    </div>
                    <div class="verticalWrap" id="recordOfSpending">
                            <div id="playerTributes">

                            </div>
                            <div id="totalTribute">

                            </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <script>
        ajax_All(42,"none");
    </script>
</section>