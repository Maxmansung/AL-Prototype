<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid">
    <div class="row pt-md-5">
    </div>
    <div class="row justify-content-center py-5">
        <div class="col-md-8 col-lg-6 col-sm-10 col-11 standardWrapper">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 funkyFont font-size-5" align="center">
                    The link you followed here does not work...
                </div>
            </div>
            <div class="row justify-content-center align-items-center py-5">
                <div class="col-6 py-5 grayBackground" align="center">Image here</div>
            </div>
        </div>
    </div>
</div>