<?php
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/controller/profileController.php");
$response = profileController::userlogin();
if (!array_key_exists("ERROR",$response)){
    $profile = new profileController($response["SUCCESS"]);
} else {
    $profile = new profileController("");
}
?>