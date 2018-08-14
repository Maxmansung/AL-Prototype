<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid pb-3 pageSize">
    <script src="/js/helpPage.js"></script>
<?php
if (isset($_GET["h"])) {
    $help = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["h"]);
} else {
    $help = "none";
}
switch ($help){
    case "building":
        include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/help/helpBuildingList.php");
        break;
    case "none":
    default:
        include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/help/helpFrontPage.php");
        break;
}
?>
</div>