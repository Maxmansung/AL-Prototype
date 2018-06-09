<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row standardWrapper justify-content-center align-items-center py-2">
    <div class="col-12 d-flex justify-content-end p-2">
        <button class="btn btn-danger btn-sm" onclick="changeView(2)">Close <i class="fas fa-ban"></i></button>
    </div>
    <div class="col-12 col-sm-11 d-flex flex-column justify-content-center p-2 zoneMapImageWrapper">

    </div>
</div>