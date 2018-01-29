<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/HUDController.php");
if ($profile->getNightfall() === 1){
    header("location:/nightfall.php");
    exit();
}
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
<article class="horizontalWrap" id="pageCenter">
    <article class="verticalWrap">
        <?php include_once($_SERVER['DOCUMENT_ROOT']."/MVC/game_pages/HUD.php")?>
        <section id="windowwrap">
            <section id="menuwrap">
                <?php if (isset($_GET["p"])){
                    $page = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["p"]);
                    $map = new mapController($avatar->getMapID());
                    if ($map->getGameType() !== "Tutorial") {
                        switch ($page) {
                            case "p":
                                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/players.php");
                                break;
                            case "c":
                                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/construction.php");
                                break;
                            case "m":
                                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/mapZone.php");
                                break;
                            case "s":
                                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/specialZone.php");
                                break;
                            default:
                                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/zoneActions.php");
                                break;
                        }
                    } else {
                        switch ($page) {
                            case "c":
                                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/constructionTutorial.php");
                                break;
                            default:
                                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/mapZoneTutorial.php");
                                break;
                        }
                    }
                } else {
                    if ($map->getGameType() !== "Tutorial") {
                        include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/zoneActions.php");
                    } else {
                        include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/game_pages/mapZoneTutorial.php");
                    }
                }
                ?>
            </section>
        </section>
        <?php
        if ($profile->getAccountType() == "admin" || $profile->getAccountType() == "mod" || $map->getGameType() == "Test"){
            echo
            '<div class="horizontalWrap" id="readyButtons">
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