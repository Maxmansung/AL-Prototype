<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row">
    <div class="col-12 standardWrapper infoWrapBuildings d-none">
        <div class="row pt-2 justify-content-center">
            <div class="col-11 standardWrapperTitle" align="center">
                Select a location to build from
            </div>
        </div>
        <div class="row p-1">
            <div class="col-4 d-flex justify-content-center">
                <button class="btn btn-outline-success" id="buttonBuild-ground" onclick="changeBuildLocation(this.id)">Ground</button>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <button class="btn btn-outline-success" id="buttonBuild-storage" onclick="changeBuildLocation(this.id)">Chest</button>
            </div>
            <div class="col-4 d-flex justify-content-center">
                <button class="btn btn-outline-success" id="buttonBuild-backpack" onclick="changeBuildLocation(this.id)">Backpack</button>
            </div>
        </div>
        <div class="row justify-content-center totalBuildingWrapper">
            <div class="col-11 buildingListWrapper font-size-2">
            </div>
        </div>
    </div>
</div>