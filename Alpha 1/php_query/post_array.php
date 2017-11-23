<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_POST['data'])){
     $data = preg_replace('#[^[],a-z0-9]#','', $_POST['data']);
     $vari = preg_replace('#[^a-z0-9]#','', $_POST['vari']);
     $table = preg_replace('#[^a-z0-9]#','', $_POST['table']);
     $poststate = "UPDATE ".$table." SET ".$vari."='".$data."' WHERE username='".$_SESSION['username']."' AND mapid='".$_SESSION['mapid']."' LIMIT 1";
     $postquery = mysqli_query($db_conx, $poststate);
     echo $poststate;
     }
?>