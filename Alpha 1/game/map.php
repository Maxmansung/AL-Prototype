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
    <script src="../js/ajax.js"></script>
    <script src="../js/map.js"></script>
    <script src="../js/user.js"></script>
    <script src="../js/stamina.js"></script>
    <script src="../js/item_stats.js"></script>
    <title>Arctic Land - Map</title>
</head>
<body onload="maploading()">
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
                <div class="menutab" id="maptab">
                    <a  class="menulink2" href="map.php">Map</a>
                </div>
                <div class="menutab2" id="playerstab">
                    <a class="menulink" href="players.php">Players</a>
                </div>
                <div class="menutab2" id="zonetab">
                    <a class="menulink" href="zone.php">Zone</a>
                </div>
                <div class="menutab2" id="buildingtab">
                    <a class="menulink" href="overview.php">Buildings</a>
                </div>
            </section>
            <section id="mappagewrap">
                <section id="mapwrapper">
                    <img src="../images/arrowup.png" class="directionbutton" id="butnorth" onclick="movedirection('n')">
                    <section id="wrapperEW">
                        <img src="../images/arrowleft.png" class="directionbutton" id="butwest" onclick="movedirection('w')">
                        <section id="surround">
                            <section id="start">

                            </section>
                        </section>
                        <img src="../images/arrowright.png" class="directionbutton" id="buteast" onclick="movedirection('e')">
                    </section>
                    <img src="../images/arrowdown.png" class="directionbutton" id="butsouth" onclick="movedirection('s')">
                </section>
                <section id="infobox">
                <div id="zonelocation">
                </div>
                <div id="environment">
                </div>
                <div id="players">
                <div>
                </section>
            </section>
        </section>
        <section id="chatwrapper">
            <div id="chatbox">
            CURRENTLY NOT IN USE
            </div>
            <input type="text" id="inputchat">
            <button id="submittext" onclick="submittext()">Post</button>
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