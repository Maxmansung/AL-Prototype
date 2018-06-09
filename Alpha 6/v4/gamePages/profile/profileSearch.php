<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="standardWrapper row mx-md-0 mx-2 mb-3 mt-md-0 mt-3 justify-content-center">
    <div class="col-10 d-flex flex-column justify-content-center p-3 align-items-center">
        <div class="font-size-2x py-2 d-none d-md-flex">Find spirit</div>
        <div class="input-group mb-2 d-md-flex d-none">
            <input type="text" class="form-control" id="profilePageSearchScreen" placeholder="Username">
            <div class="input-group-append">
                <div class="input-group-text clickableFlashMore" id="profilePageSearchScreenButton" onclick="searchForSpirits(2)"><i class="fas fa-search"></i></div>
            </div>
        </div>
    </div>
</div>