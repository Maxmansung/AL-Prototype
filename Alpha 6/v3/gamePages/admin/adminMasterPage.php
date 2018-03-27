<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid">
    <script src="/js/adminPage.js"></script>
    <?php
    if (isset($_GET["a"])) {
        $admin = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["a"]);
    } else {
        $admin = "none";
    }
    switch ($admin){
        case "news":
            if ($profile->getAccountType() >= 3){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/postNews.php");

            }
            break;
        case "map":
            if ($profile->getAccountType() >= 6){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminNewMap.php");

            }
            break;
        case "snowman":
            if ($profile->getAccountType() >= 3){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminEditMap.php");

            }
            break;
        case "report":
            if ($profile->getAccountType() >= 4){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminReports.php");

            }
            break;
        case "none":
        default:
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            break;
    }
    ?>
</div>