<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid pb-3 pageSize">
    <script src="/js/adminPage.js"></script>
    <?php
    if (isset($_GET["a"])) {
        $admin = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["a"]);
    } else {
        $admin = "none";
    }
    switch ($admin){
        case "news":
            if ($profile->getAccessPostNews()===0){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/postNews.php");
            }
            break;
        case "map":
            if ($profile->getAccessNewMap()===0){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminNewMap.php");
            }
            break;
        case "snowman":
            if ($profile->getAccessEditMap()===0){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminEditMap.php");
            }
            break;
        case "report":
            if ($profile->getAccessEditForum()===0){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminReports.php");
            }
            break;
        case "users":
            if ($profile->getAccessEditForum()===0){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminEditUsers.php");
            }
            break;
        case "none":
        default:
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            break;
    }
    ?>
</div>