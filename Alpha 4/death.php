<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/avatarController.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/mapController.php");
if ($profile->getProfileID() === ""){
    header("location:/index.php");
    exit();
}
if ($profile->getGameStatus() != "death"){
    header("location:/ingame.php");
    exit();
}
$deathAvatar = new deathScreenController($profile->getProfileID());
if ($deathAvatar->getProfileID() == "") {
    $profile->confirmdeath();
    header("location:/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/profile.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <script src="js/ingame.js"></script>
    <script src="js/deathScreen.js"></script>
    <script src="js/canvasFunctions.js"></script>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once("templates/template_pageTop.php"); ?>
<article>
    <section id="death">
        <div class="horizontalWrap" id="deathWrapper">
            <div class="verticalWrap" id="playStatistics">
                <div id="deathSubHeading">Play Statistics</div>
                <canvas id="myCanvas"></canvas>
                <div id="myLegend"></div>
            </div>
            <div id="verticalLine"></div>
            <div class="verticalWrap" id="playAchievements">
                <div id="deathSubHeading">Achievements</div>
                <div class="verticalWrap" id="deathAchievements">
                </div>
            </div>
        </div>
        <button onclick="confirmDeath()" id="confirmDeath">Confirm Death</button>
    </section>
</article>
<script>
    getDeathInfo();
</script>
<?php include_once("templates/template_pageBottom.php"); ?>
</body>
</html>