<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/ajax_php/ajax_MVC.php");
if (isset($_GET["page"])) {
    $page = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["page"]);
} else {
    $page = "none";
}
if ($profile->getAvatar() == 0){
    if ($profile->getGameStatus() == "in") {
        $profile->setGameStatus("ready");
        $profile->uploadProfile();
        header("location:/");
        exit("No access");
    }
}
if (isset($_COOKIE['lang'])){
    $language = $_COOKIE['lang'];
} else {
    $language = 1;
}
if ($profile->getProfileID() != 0){
    $profile->getProfileAccess();
}
$accessed = true;
$headerName = "";
$pageName = "";
switch ($language){
    /*
    case 2:
        include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/germanLanguage.php");
        $text = new germanLanguage();
        $javascript = "englishScript";
        break;
    case 3:
        include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/swedishLanguage.php");
        $text = new swedishLanguage();
        $javascript = "englishScript";
        break;
    case 4:
        include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/frenchLanguage.php");
        $text = new frenchLanguage();
        $javascript = "englishScript";
        break;
    */
    case 5:
        include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/cowLanguage.php");
        $text = new cowLanguage();
        $javascript = "englishScript";
        break;
    case 1:
    default:
    include_once ($_SERVER['DOCUMENT_ROOT']."/MVC/data/languages/englishLanguage.php");
    $text = new englishLanguage();
    $javascript = "englishScript";
        break;
}

if ($profile->getProfileID() == "" || $profile->getAccountType() > 7){
    $headerName = "/gamePages/login/template_pageTopSignout.php";
    switch($page){
        case "credits":
            $pageName = "/gamePages/other/credits.php";
            break;
        case "help":
            $pageName = "/gamePages/other/helpPage.php";
            break;
        case "news":
            $pageName = "/gamePages/other/news.php";
            break;
        case "none":
            $pageName = "/gamePages/login/loginMasterPage.php";
            break;
        case "activation":
            $pageName = "/gamePages/accountSignin/activation.php";
            break;
        case "forgotten":
            $profile = new profileController($_GET["u"]);
            $time = time() - $profile->getPasswordRecoveryTimer();
            if ($profile->getPasswordRecovery() !== $_GET['p'] || $time > 1800){
                $pageName = "/gamePages/login/updatePasswordError.php";
            } else {
                $pageName = "/gamePages/login/updatePassword.php";
            }
            break;
        default:
            header("location:/");
            exit("No access");
            break;
    }
} else {
    $headerName = "/templates/template_pageTop.php";
    switch ($page) {
        case "credits":
            $pageName = "/gamePages/other/credits.php";
            break;
        case "help":
            $pageName = "/gamePages/other/helpPage.php";
            break;
        case "news":
            $pageName = "/gamePages/other/news.php";
            break;
        case "join":
            $pageName = "/gamePages/joinGame/joinGameMasterPage.php";
            break;
        case "admin":
            if ($profile->getAccessAdminPage() === 1) {
                $pageName = "/gamePages/admin/adminMasterPage.php";
            } else {
                header("location:/index.php");
            }
            break;
        case "spirit":
            $pageName = "/gamePages/profile/profileMasterPage.php";
            break;
        case "forum":
            $pageName = "/gamePages/forums/forumsMasterPage.php";
            break;
        case "edit":
            $pageName = "/gamePages/profile/profileOverviewEdit.php";
            break;
        case "score":
            $pageName = "/gamePages/leaderboard/leaderboardMain.php";
            break;
        case "nightfall":
            $pageName = "/gamePages/other/nightfall.php";
            break;
        case "none":
        default:
            if ($profile->getGameStatus() == "death") {
                $death = new deathScreenController($profile->getProfileID());
                if ($death->getProfileID() !== $profile->getProfileID()){
                    $profile->setGameStatus("ready");
                    $profile->uploadProfile();
                    header("location:/");
                    exit("No access");
                } else {
                    $pageName = "/gamePages/death/deathMasterPage.php";
                }
            } else if ($profile->getGameStatus() == "in") {
                if ($profile->getAvatar() == 0) {
                    $profile->setGameStatus("death");
                    $profile->uploadProfile();
                    header("location:/");
                    exit("No access");
                } else {
                    $pageName = "/gamePages/ingame/gameMasterPage.php";
                }
            } else {
                $pageName = "/gamePages/joinGame/joinGameMasterPage.php";
            }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/CSS/main.css">
    <link rel="stylesheet" href="/CSS/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/CSS/colours.css">
    <link rel="stylesheet" href="/CSS/textFormat.css">
    <link rel="stylesheet" href="/CSS/mapScaler.css">
    <link rel="icon" href="images/baseImages/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/baseImages/iconSnowman.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Arctic Lands Game</title>
</head>
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/ajaxSystem_JS.js"></script>
<script src="/js/errorChecker.js"></script>
<script src="/js/textFormatting.js"></script>
<script src="/js/languageJavascript/<?php echo $javascript?>.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
<body class="bg-al-black">
<?php
include_once($_SERVER['DOCUMENT_ROOT'].$headerName);
include_once($_SERVER['DOCUMENT_ROOT'] .$pageName);
include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>
<script>pageSetupFinal()</script>