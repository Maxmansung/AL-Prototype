<?php
if (isset($_FILES[0])){
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/websiteVars.php");
    include_once(PROJECT_ROOT."/MVC/filesInclude.php");
    $response = profileController::userlogin();
    if (array_key_exists("ERROR",$response)){
        echo json_encode($response);
    } else {
        if (isset($response["SUCCESS"])) {
            $profile = new profileController($response["SUCCESS"]);
        } else {
            $profile = new profileController("");
        }
        $checker = new profileImagesController();
        $response = $checker->checkUpload($_FILES[0],$profile->getProfileID());
        echo json_encode($response);
    }
}
