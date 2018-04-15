<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
if (isset($_GET["f"])) {
    $forum = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["f"]);
} else {
    $forum = "none";
}
?>
<script src="/js/forumPage.js"></script>
<div class="container-fluid grayTransparentBackground pb-3">
    <?php
    switch ($forum) {
        case "none":
            include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumSelectPage.php");
            break;
        default:
            include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumThreadsPage.php");
            break;
    }
    ?>
</div>