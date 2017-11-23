<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_POST['var1'])){
    $query = preg_replace('#[^a-z0-9]#','', $_POST['var1']);
    $teststate = "SELECT ".$query." FROM testing WHERE data1='test'";
    $testquery = mysqli_query($db_conx, $teststate);
    $row = mysqli_fetch_row($testquery);
    $jsonData = intval($row[0]);
    echo json_encode($jsonData);
}
?>