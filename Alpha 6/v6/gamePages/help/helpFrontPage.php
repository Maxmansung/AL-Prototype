<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
    <div class="row d-flex flex-column justify-content-center align-items-center login-window m-5 ">
        <div class="font-weight-bold">HELP PAGE</div>
        <div>This page has not been created yet</div>
        <div>However there is a "Buildings" page here:</div>
        <div class="clickableLink font-weight-bold" onclick="goToHelpPage('building')">BUILDINGS LINK</div>
    </div>