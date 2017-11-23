<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])){
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $data = preg_replace('#[^[],a-z0-9]#','', $_POST['data']);
    $teststate = "SELECT fitems FROM mapzones WHERE mapid='$mapid' AND zonenum='$data'";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$jsonData = $row["fitems"];
    }
    echo $jsonData;
}
?>