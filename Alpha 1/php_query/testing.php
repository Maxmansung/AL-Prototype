<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
$newtime = round(microtime(true) * 1000);
echo $newtime;
?>