<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])){
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $data = preg_replace('#[^[],a-z0-9]#','', $_POST['data']);
    $jsonData = "{";
    $teststate = "SELECT mapping FROM ingamegroups WHERE mapid='$mapid' AND playergroup='$data'";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$jsonData = $row["mapping"];
    	}
    echo $jsonData;
}
?>