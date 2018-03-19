<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container justify-content-center">
    <div class="row col-11 justify-content-between p-0 mx-0 d-md-flex d-none">
        <div class="adminTab col-3 funkyFont font-size-4 blackColour clickable" onclick="selectPage(this.id)" id="news">Post News</div>
        <div class="adminTab col-3 funkyFont font-size-4 blackColour clickable" onclick="selectPage(this.id)" id="map">Create Map</div>
        <?php
        if ($profile->getAccountType() <= 2){
            echo '<div class="adminTab col-3 funkyFont font-size-4 blackColour clickable" onclick="selectPage(this.id)" id="snowman">Manage Maps</div>';
        }
        ?>
    </div>
    <div class="row col-11 justify-content-between p-0 mx-0 d-md-none d-flex">
        <div class="adminTab col-3 funkyFont font-size-4 blackColour clickable" onclick="selectPage(this.id)" id="news">Post News</div>
        <div class="adminTab col-3 funkyFont font-size-4 blackColour clickable" onclick="selectPage(this.id)" id="map">Create Map</div>
        <?php
        if ($profile->getAccountType() <= 2){
            echo '<div class="adminTab col-3 funkyFont font-size-4 blackColour clickable" onclick="selectPage(this.id)" id="snowman">Manage Maps</div>';
        }
        ?>
    </div>
    <?php
    if (isset($_GET["a"])) {
        $admin = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["a"]);
    } else {
        $admin = "none";
    }
    switch ($admin){
        case "news":
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/postNews.php");
            break;
        case "map":
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminNewMap.php");
            break;
        case "snowman":
            if ($profile->getAccountType() != 1){
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            } else {
                include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminEditMap.php");

            }
            break;
        case "none":
        default:
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminFrontPage.php");
            break;
    }
    ?>
    <script src="/js/adminPage.js"></script>
</div>