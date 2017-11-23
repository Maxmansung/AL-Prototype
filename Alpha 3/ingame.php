<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/HUDController.php");
if ($profile->getProfileID() === ""){
    header("location:/index.php");
    exit();
}
if ($profile->getGameStatus() != "in"){
    if ($profile->getGameStatus() == "death"){
        header("location:/death.php");
        exit();
    } else {
        header("location:/joingame.php");
        exit();
    }
}
if ($profile->getAvatar() === null){
    $profile->setGameStatus("death");
    $profile->uploadProfile();
    header("Refresh:0");
    exit();
}
$avatar = new avatarController($profile->getAvatar());
$map = new mapController($avatar->getMapID());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <script src="/js/ingame.js"></script>
    <script src="/js/canvasFunctions.js"></script>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
<article class="horizonalWrap" id="pageCenter">
    <article class="verticalWrap">
        <section id="HUD">
            <?php include_once($_SERVER['DOCUMENT_ROOT']."/MVC/game_pages/HUD.php")?>
        </section>
        <section id="windowwrap">
            <section id="menuwrap">
                <?php if (isset($_GET["p"])){
                    $page = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["p"]);
                    switch ($page){
                        case "p":
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/players.php");
                            break;
                        case "bb":
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/buildings.php");
                            break;
                        case "bo":
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/overview.php");
                            break;
                        case "bf":
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/firepit.php");
                            break;
                        case "bs":
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/storage.php");
                            break;
                        case "a":
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/avatar.php");
                            break;
                        case "m":
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/mapZone.php");
                            break;
                        default:
                            include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/zoneActions.php");
                            break;
                    }
                } else {
                    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/zoneActions.php");
                }
                ?>
            </section>
        </section>
        <?php
        if ($profile->getAccountType() == "admin" || $profile->getAccountType() == "mod" || $map->getGameType() == "Test"){
            echo
            '<div class="horizonalWrap" id="readyButtons">
            <button class="HUDButton" onclick="testdie()">Death</button>
            <br>
            <button class="HUDButton" onclick="testStamina()" >Stamina</button>
            <br>
            <button class="HUDButton" onclick="dayEnding()">End Day</button>
            </div>';
            }
        ?>
    </article>
</article>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>