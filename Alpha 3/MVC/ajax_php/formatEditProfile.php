<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
if (isset($_POST['bio'])) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/profileAchievementController.php");
    $bio = htmlentities($_POST['bio'], ENT_QUOTES | ENT_SUBSTITUTE);
    $age = preg_replace('#[^0-9]#', '', $_POST['age']);
    $gender = preg_replace('/[^\w-, ]/', '', $_POST['gender']);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $picture = preg_replace('#[^?.! ,A-Za-z0-9]#', '', $_POST['picture']);
    $response = profileAchievementController::updateProfile($bio,$age,$gender,$country,$picture,$profile->getProfileID());
    echo json_encode($response);
} else if (isset($_FILES[0])){
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/profileImagesController.php");
    $checker = new profileImagesController();
    $response = $checker->checkUpload($_FILES[0],$profile->getProfileID());
    echo json_encode($response);
} else {
    echo json_encode(array("ERROR"=>100));
}
?>