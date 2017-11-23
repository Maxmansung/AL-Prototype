<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_POST['text'])){
     $text = preg_replace('#[^-.,?!&()" A-Za-z0-9]#','', $_POST['text']);
     $day = preg_replace('#[^a-z0-9]#','', $_POST['day']);
     $type = preg_replace('#[^a-z0-9]#','', $_POST['type']);
     $zone = preg_replace('#[^A-Za-z0-9]#','', $_POST['zone']);
     $player = preg_replace('#[^A-Za-z0-9]#','', $_POST['player']);
     $map = preg_replace('#[^A-Za-z0-9]#','', $_SESSION['mapid']);
     $timestamp = round(microtime(true) * 1000);
     $poststate =  "INSERT INTO `chatlog` (`uniqueid`, `mapid`, `chattype`, `day`, `playerid`, `timestamp`, `text`, `zoneid`) VALUES (NULL, '".$map."', '".$type."', '".$day."', '".$player."', '".$timestamp."', '".$text."', '".$zone."')";
     //$postquery = mysqli_query($db_conx, $poststate);
     echo $poststate;
     }
?>