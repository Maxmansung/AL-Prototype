<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_POST['zone'])){
     $zone = preg_replace('#[^A-Za-z0-9]#','', $_POST['zone']);
     $map = preg_replace('#[^A-Za-z0-9]#','', $_SESSION['mapid']);
     $jsonData = '{';
     $poststate =  "SELECT * FROM chatlog WHERE mapid='$map' AND zoneid='$zone'";
     $postquery = mysqli_query($db_conx, $poststate);
     $i = 0;
     while ($row = mysqli_fetch_assoc($postquery)){
        $chattype = $row["chattype"];
        $day = $row["day"];
        $playerid = $row["playerid"];
        $timestamp = $row["timestamp"];
        $timestamp2 = (round(microtime(true) * 1000)) - $timestamp;
        $text = $row["text"];
        $jsonData .= '"'.$i.'":{ "chattype":"'.$chattype.'","day":'.$day.',"playerid":'.$playerid.', "timestamp":'.$timestamp2.', "text":"'.$text.'"},';
        $i++;
     }
     $jsonData = chop($jsonData, ",");
	 $jsonData .= '}';
     echo $jsonData;
     }
?>