<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])) {
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $userid =  preg_replace('#[^A-Za-z0-9]#','', $_SESSION['username']);
    $groupstate = "SELECT * FROM maps WHERE mapid='$mapid'";
    $testquery = mysqli_query($db_conx, $groupstate);
    while ($row = mysqli_fetch_assoc($testquery)) {
        $timer = $row["timer"];
    }
    $newtime = round(microtime(true) * 1000);
    $daylength = 57600000;
    $timer = $newtime - $timer;
    $timer = $daylength - $timer;
}
echo $timer;
?>