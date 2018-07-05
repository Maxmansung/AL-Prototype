<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
include_once(PROJECT_ROOT."/MVC/filesInclude.php");
$response = profileController::userlogin();
if (!array_key_exists("ERROR", $response)) {
    $profile = new profileController($response["SUCCESS"]);
} else {
    $profile = new profileController("");
}