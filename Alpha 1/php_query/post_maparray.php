<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_POST['data'])){
     $data0 = preg_replace('#[^[],A-Za-z0-9]#','', $_POST['data']);
     $vari0 = preg_replace('#[^a-z0-9]#','', $_POST['vari']);
     $table0 = preg_replace('#[^a-z0-9]#','', $_POST['table']);
     $where0 = preg_replace('#[^a-z0-9]#','', $_POST['where']);
     $poststate0 = "UPDATE ".$table0." SET ".$vari0."='".$data0."' WHERE mapid='".$_SESSION['mapid']."' AND zonenum='".$where0."' LIMIT 1";
     $postquery0 = mysqli_query($db_conx, $poststate0);
     echo $poststate0;
     }
?>