<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])) {
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $groupstate = "SELECT * FROM ingamegroups WHERE mapid='$mapid'";
    $testquery = mysqli_query($db_conx, $groupstate);
    while ($row = mysqli_fetch_assoc($testquery)) {
        $playergroup = $row["playergroup"];
        $mapping = $row["mapping"];
        $invited = $row["invited"];
        $kick = $row["kick"];
        $known = $row["known"];
    }
}
?>