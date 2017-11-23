<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])){
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $teststate = "SELECT * FROM maps WHERE mapid='$mapid'";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$mapname = $row["mapname"];
    	$players = $row["players"];
    	$day = $row["day"];
    	$timer = $row["timer"];
    	$temperature = $row["temperature"];
		$jsonData = '{"mapname":"'.$mapname .'","players":'.$players.',"day":'.$day.', "temperature":'.$temperature.', "timer":'.$timer.'}';
    }
    echo $jsonData;
}
?>