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
    <section id="deathWrapper">
        <section class="horizontalWrap" id="deathScreenWrap">
            <section id="deathOverviewWrapper">
                <div class="boldTitle">
                    YOU HAVE DIED!
                </div>
                <div id="deathCauseSection">
                    Cause of death here
                </div>
                <div id="deathCauseDescription">
                    Description of death here
                </div>
                <div id="deathSurvivedTotal">
                    Day of death here
                </div>
                <div id="deathMapSection">
                    Map name here
                </div>
            </section>
            <section class="verticalWrap" id="StatisticWrapper">
                <div class="verticalWrap" id="playAchievements">
                    <div id="deathSubHeading">Achievements</div>
                    <div id="deathAchievements">
                    </div>
                    <div id="deathAchieveScore">

                    </div>
                </div>
                <div class="verticalWrap" id="shrineAchievements">
                    <div id="deathSubHeading">
                        Gods Favour
                    </div>
                    <div id="shrineScores">
                        Shrines Here
                    </div>
                    <div id="totalScoreTitle">
                        Total:
                    </div>
                    <div id="shrineScoresTotal">
                        Total Here
                    </div>
                </div>
            </section>
        </section>
        <button onclick="confirmDeath()" id="confirmDeath">Confirm Death</button>
    </section>
</article>
<script>
    getDeathInfo();
</script>
<?php include_once("templates/template_pageBottom.php"); ?>
</body>
</html>