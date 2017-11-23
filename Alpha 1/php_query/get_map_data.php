<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])){
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $jsonData = "{";
    $teststate = "SELECT * FROM mapzones WHERE mapid='$mapid'";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$location = $row["zonenum"];
    	$environ = $row["environ"];
    	$fitems = $row["fitems"];
    	$depleted = $row["depleted"];
    	$searchcount = $row["searchcount"];
    	$buildings=$row["buildings"];
    	$fuel = $row["fuel"];
    	$groupowner = $row["groupowner"];
		$jsonData .= '"'.$location.'":{ "location":'.$location.',"environ":'.$environ.',"fitems":'.$fitems.', "depleted":'.$depleted.', "searchcount":'.$searchcount.',"buildings":'.$buildings.', "fuel":'.$fuel.', "groupowner":'.$groupowner.' },';
    }
    $jsonData = chop($jsonData, ",");
	$jsonData .= '}';
    echo $jsonData;
}
?>