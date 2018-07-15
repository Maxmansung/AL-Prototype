<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
if (isset($_GET['u']) && isset($_GET['e']) && isset($_GET['p'])) {
    $response = $profile->activate($_GET['u'], $_GET['e'], $_GET['p']);
    if (array_key_exists("ERROR",$response)){
        $pageDetails = "/gamePages/accountSignin/errorMessage.php";
        $errorMessage = $response["ERROR"];
    } else {
        $pageDetails = "/gamePages/accountSignin/activationMessage.php";
        $profileName = strtoupper($response['DATA']);
    }
} else {
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid">
    <div class="row pt-md-5">
    </div>
    <div class="row justify-content-center py-5">
        <div class="col-md-8 col-lg-6 col-sm-10 col-11 standardWrapper">
            <?php
            include_once($_SERVER['DOCUMENT_ROOT'].$pageDetails);
            ?>
        </div>
    </div>
</div>
