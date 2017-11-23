<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])){
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $teststate = "SELECT ready, alive FROM ingameavatars WHERE mapid='$mapid'";
    $testquery = mysqli_query($db_conx, $teststate);
    $jsonData = "[";
    while ($row = mysqli_fetch_assoc($testquery)){
    	$ready = $row["ready"];
    	$alive = $row["alive"];
    	if ($alive == 1){
		    $jsonData .= $ready.",";
		    }
		}
    $jsonData = chop($jsonData, ",");
	$jsonData .= ']';
    echo $jsonData;
}
?>