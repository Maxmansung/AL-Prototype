<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
if ($profile->getProfileID() !== ""){
    header("location:/index.php");
    exit();
}
if (isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])) {
    $profile->activate($_GET['u'], $_GET['e'], $_GET['p']);
    header("location: message.php?msg=activation_success");
    exit();
}