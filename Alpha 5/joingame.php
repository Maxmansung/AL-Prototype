<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
if ($profile->getProfileID() === ""){
    header("location:/index.php");
    exit();
}
if ($profile->getGameStatus() != "ready"){
    header("location:/ingame.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Arctic Lands - Join Game</title>
    <link rel="stylesheet" href="/CSS/joinMap.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <script src="/js/joinGame_JS.js"></script>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageTop.php"); ?>
<div id="pageMiddle">
    <div class="mapListWrap">
        <div class="mapsTitle">
            Open Maps
        </div>
        <div class="mapsWriting">
            Select a map to join
        </div>
        <div id="joinMaps">
        </div>
    </div>
    <div class="mapListWrap" id="adminWrapper">
        <div class="mapsTitle">
            Maps in progress
        </div>
        <div class="mapsWriting">
            This section below is accessible only to admin users
        </div>
        <div id="adminMaps">
        </div>
    </div>
</div>
<script>
    ajax_All(39,"none",14);
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageBottom.php"); ?>
</body>
</html>