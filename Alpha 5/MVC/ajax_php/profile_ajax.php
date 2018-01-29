<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
include_once(PROJECT_ROOT."/MVC/filesInclude.php");
$profile = new profileController("");
if (isset($_POST["type"])) {
    $type = preg_replace('#[^A-Za-z0-9]#i', '', $_POST['type']);
    $response = array("ERROR"=>"x");
    if ($type === "login" ){
        $response = $profile->login($_POST["u"],$_POST["p"],$_POST["sec"]);
    } elseif ($type === "signup"){
        $response = $profile->signup($_POST["u"],$_POST["e"],$_POST["p"],$_POST["sec"]);
    } elseif ($type === "recovery"){
        $user = preg_replace('#[^A-Za-z0-9?!()_\s]#i', '', $_POST['u']);
        $profile = new profileController($user);
        $response = $profile->updatePassword($_POST["p"],$_POST["sec"],$user);
    } elseif ($type === "newPass"){
        $response = profileController::createRecoveryPassword($_POST["u"],$_POST["e"]);
    }
    echo json_encode($response);
}