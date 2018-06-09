<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row">
    <div class="col-12 standardWrapper d-none infoWrapShrines">
        <div class="row pt-2 justify-content-around infoWrapShrinesList">
        </div>
    </div>
</div>