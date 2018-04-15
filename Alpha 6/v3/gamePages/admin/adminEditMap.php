<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-sm-11 standardWrapper mt-5">
        <div class="row justify-content-end font-weight-bold font-size-2x"><div class="mx-3 mt-2 clickableLink" onclick = "selectPage(this.id)" id="none"><i class="fas fa-reply mr-2"></i>Back</div>
        </div>
        <div class="row">
            <div class="col-12 font-weight-bold font-size-4 px-3">Control Map's</div>
        </div>
        <div class="row justify-content-center font-size-2">
            <div class="col-11 pt-3">
                Here you have the power to edit maps, this is reserved for the Admins of the game.
            </div>
            <div class="col-11 pt-3">
                Please use this area to edit maps, including deleting them. You can also directly interact with players currently in games in order to ban or kill those that require it.
            </div>
            <div class="col-11 pt-3">
                This page should be used as infrequently as possible and every action on here will be logged
            </div>
        </div>
        <div class="row justify-content-center my-3">
            <div class="standardWrapperTitle col-11 font-size-2x" align="center" id="adminEditMapTitle">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-11" id="mapDetailsAdminWrapper">
            </div>
            <div class="col-11" id="mapDetailsDeadAdminWrapper">
            </div>
        </div>
        <div class="row justify-content-center my-3">
            <div class="standardWrapperTitle col-11 font-size-2x">
                Active Maps
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-11" id="mapListWrapper">
            </div>
        </div>
    </div>
</div>
<script>getAllMapEdit()</script>