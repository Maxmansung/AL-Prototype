<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/HUDController.php");
$HUD = HUDController::getHUDStats($profile->getAvatar());
$view = $HUD->returnVars();
echo json_encode($view);