<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/ajax_php/ajax_MVC.php");
if (isset($_GET["page"])) {
    $page = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["page"]);
} else {
    $page = "none";
}
$testing = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/CSS/main.css">
    <link rel="stylesheet" href="/CSS/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/CSS/colours.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Arctic Lands Prototype</title>
</head>
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/ajaxSystem_JS.js"></script>
<script src="/js/errorChecker.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<body class="bg-al-black">
<?php
if ($profile->getProfileID() == ""){
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTopSignout.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/gamePages/login/loginMasterPage.php");
} else{
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php");
    switch ($page) {
        case "admin":
            include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/admin/adminMasterPage.php");
            break;
        case "spirit":
            include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileMasterPage.php");
            break;
        case "forum":
            include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumsMasterPage.php");
            break;
        case "none":
        default:
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/ingame/gameMasterPage.php");
    }
}
?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>