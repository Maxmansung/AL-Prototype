<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
if ($profile->getProfileID() === ""){
    header("location:/index.php");
    exit();
}
if (isset($_GET["p"])){
    include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/forumCatagoriesController.php");
    $page = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["p"]);
    $category = new forumCatagoriesController($page, $profile->getProfileID());
    if ($category->getAccessType() == false) {
        header("location:/forum.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/forum.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <script src="js/forum_JS.js"></script>
    <script src="js/textFormatting_JS.js"></script>
    <script src="js/jquery-3.1.1.1.js"></script>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
<article id="pageCenter">
    <?php if (isset($_GET["p"])){
        $page = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["p"]);
        switch ($page){
            case "p":
                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/forum_pages/forumThreads.php");
                break;
            default:
                include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/forum_pages/forumThreads.php");
                break;
        }
    } else {
        include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/forum_pages/forumOverview.php");
    }
    ?>
</article>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>