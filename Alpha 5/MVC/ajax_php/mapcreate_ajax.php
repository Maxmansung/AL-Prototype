<?php
echo "Welcome<br>";
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
if (isset($_POST['map'])) {
    $name = preg_replace('#[^?.! ,A-Za-z0-9]#', '', $_POST['map']);
    $player = preg_replace('#[^0-9]#', '', $_POST['player']);
    $invent = preg_replace('#[^0-9]#', '', $_POST['invent']);
    $edge = preg_replace('#[^0-9]#', '', $_POST['edge']);
    $stamina = preg_replace('#[^0-9]#', '', $_POST['stamina']);
    $length = preg_replace('#[^?.! ,A-Za-z0-9]#', '', $_POST['length']);
    $temp = preg_replace('#[^0-9]#', '', $_POST['Temp']);
    $stemp = preg_replace('#[^0-9]#', '', $_POST['SurviTemp']);
    $tempm = preg_replace('#[^0-9]#', '', $_POST['TempMod']);
    $type = preg_replace('#[^?.! ,A-Za-z0-9]#', '', $_POST['gameType']);

    //This verifies the map size to ensure it is not too big or small
    if ($edge > 40){
        $edge = 40;
    } elseif ($edge < 1){
        $edge = 1;
    }

    //This is the process to create a map using the MapCreate object
    include_once($_SERVER['DOCUMENT_ROOT'] . "/MVC/controller/newMapJoinController.php");
    $response = newMapJoinController::createNewMap($name,$player,$invent,$edge,$stamina,$length,$temp,$stemp,$tempm,$type);
    $_SESSION["Error"] = $response["ERROR"];
}
//This redirects back to the admin page if the name is in use already
header("Location: /admin/admin.php");
exit();
?>