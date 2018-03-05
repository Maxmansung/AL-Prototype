<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/shrineController.php");
$shrineZone = shrineController::findShrine($avatar->getZoneID());
if ($shrineZone === false) {
    echo "<script>
            window.location.href='/ingame.php?p=c';
            </script>";
}
$shrine = new shrineController($shrineZone);
?>
<script src="/js/overview_JS.js"></script>
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
                <section id="zoneOverviewChoice">
                </section>
                <div class="horizontalWrap">
                    <div class="verticalWrap" id="specialZoneDescription">
                        <div id="zoneOverviewDescription" align="center">
                            <?php
                            echo $shrine->getDescription();
                            ?>
                        </div>
                        <div class="specialBuildingImageWrap">
                            <?php
                            echo "<img src='/images/shrines/".$shrine->getShrineIcon()."' class='specialBuildingImage'>"
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
        ajax_All(42,"none",5);
    </script>
</section>