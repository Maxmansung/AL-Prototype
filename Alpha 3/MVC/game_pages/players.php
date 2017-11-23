<script src="/js/players_JS.js"></script>
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
        <a class="menulink">Players</a>
    </div>
    <div class="menutab2" id="buildingtab">
        <a href="/ingame.php?p=bo" class="menulink">Buildings</a>
</section>
<section id="playerspagewrap">
    <section id="movementLog">
        <div id="movementLogTitle">
            Party Events
        </div>
        <div id="movementLogActions">

        </div>
    </section>
    <section class="horizonalWrap">
        <section id="playerbox">
            <strong>Players in the game</strong>
            <section id="playerbox2">
            </section>
        </section>
        <section id="otherplayerswrap">
            <section id="groupbox">
            </section>
            <section id="playerinvites">
            </section>
            <section id="playerkicks">
            </section>
            <section id="zoneplayersbox">
            </section>
            <script>
                ajax_All(25,"none");
            </script>
        </section>
    </section>
</section>