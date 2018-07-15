<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row d-flex justify-content-center">
    <div class="col-11">
        <div class="col-12">Backpack</div>
        <div class="backpackWrapper d-flex flex-row flex-wrap pt-1 pr-1 pb-2 pl-2 col-12">
        </div>
    </div>
</div>
<div class="row justify-content-center py-3">
    <div class="col-11">
        <div class="row">
            <div class="col-12 itemLocationBorder1 d-none">
            </div>
            <div class="col-12 itemLocationBorder2 d-block">
            </div>
        </div>
        <div class="row">
            <div class="col-6 d-flex justify-content-center itemLocationButton itemLocationButtonGround" onclick="changeLocation(0)">
                Ground
            </div>
            <div class="col-6 d-flex justify-content-center itemLocationButton itemLocationButtonChest" onclick="changeLocation(1)">
                Chest
            </div>
        </div>
    </div>
</div>