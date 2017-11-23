<?php
include_once("../login/check_login_status.php");
if(!isset($_SESSION["username"])){
    header("location: ../login/login.php");
}else {
    $u = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["username"]);
}
$mapstatement = "SELECT currentgame FROM users WHERE username='$u' LIMIT 1";
$mapquery = mysqli_query($db_conx, $mapstatement);
while ($row = mysqli_fetch_assoc($mapquery)){
    $_SESSION["mapid"] = $row['currentgame'];
    }
include_once("check_ingame.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>var username = <?php echo json_encode($_SESSION["username"]); ?></script>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon"/>
    <script src="../js/jquery-3.1.1.js"></script>
    <script src="../js/stamina.js"></script>
    <script src="../js/zoneinfo.js"></script>
    <script src="../js/item_stats.js"></script>
    <title>Arctic Land - Zone</title>
</head>
<body onload="ajax_testmap()">
    <?php include_once("../templates/template_pageTop.php"); ?>
<article>
    <section id="windowwrap">
        <section id="HUD">
            <div id="daynumber">
            </div>
            <div id="hudtimer">
            </div>
            <div id="staminabox">
                Stamina
                <div id="staminawrapper">
                </div>
            </div>
            <div id="tempwrapper">
                <div id="currenttemp">
                    <img src="../images/thermometer.png">
                    <div id="tempdata">
                    </div>
                </div>
            </div>
            <div id="readywrap">
                <img id="readyimage" src="../images/buttonready1.png" onclick='setready()'>
            </div>
        </section>
        <section id="menuwrap">
            <section id="gamemenu">
                <div class="menutab2" id="maptab">
                    <a class="menulink" href="map.php">Map</a>
                </div>
                <div class="menutab2" id="playerstab">
                    <a class="menulink" href="players.php">Players</a>
                </div>
                <div class="menutab" id="zonetab">
                    <a class="menulink2" href="zone.php">Zone</a>
                </div>
                <div class="menutab2" id="buildingtab">
                    <a class="menulink" href="overview.php">Buildings</a>
                </div>
            </section>
            <section id="zonepagewrap">
                <section id="zoneinformation">
                </section>
                <section id="playeritemwrap">
                    <section id="backpackwrap">
                        Backpack
                        <section id="backpack">
                        </section>
                    </section>
                    <section id="playeritemuse">
                        <div id="dropdownwrap">
                            Use items:
                            <span id="useitemspan"></span>
                            <select id="itemactions">
                                <option value="none">Error</option>
                            </select>
                            <span id="useitemspan"></span>
                            <button id="actionbutton" onclick="itemvalue()">Action</button>
                        </div>
                    </section>
                </section>
                <section id="grounditemswrap">
                    Ground
                    <section id="grounditems">
                    </section>
                </section>
                <div>
                <button id="searchbutton"onclick="checkdepleted()">Search</button>
                </div>
            </section>
        </section>
    </section>
</article>
<div id="loadingscreen">
    <div id="loadingwriting">
    <img src="../images/loading.png">
    </div>
</div>
<?php include_once("../templates/template_pageBottom.php"); ?>
</body>
</html>