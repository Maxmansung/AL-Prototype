<?php
include_once("../login/check_login_status.php");
$u = $_SESSION['username'];
$map = $_SESSION['mapid'];
header("Content-Type: application/json");
if(isset($_POST['data'])){
    $teststate = "SELECT maxplayers FROM `testing` WHERE `index`=2";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$max = $row["maxplayers"];
    	}
    $teststate2 = "SELECT players FROM maps WHERE mapid='$map'";
    $testquery2 = mysqli_query($db_conx, $teststate2);
    while ($row2 = mysqli_fetch_assoc($testquery2)){
        $current = $row2["players"];
    }
    $jsonData = $max - $current;
    echo $jsonData;
     }
?>