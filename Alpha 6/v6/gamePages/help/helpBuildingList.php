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
            <div class="col-lg-3 col-xl-2 col-md-4 col-sm-5 col-12 font-size-2 pr-sm-0 order-2 order-sm-1">
                <div class="d-flex flex-column mb-3 borderAll grayBorder p-2">
                    <div class="font-size-3 font-weight-bold">Building List</div>
                    <div class="horizontalLine mb-2"></div>
                    <div class="buildingsListIndex d-flex flex-column">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-9 col-sm-7 col-xl-10 order-1 order-sm-2">
                <div class="mb-3 borderAll grayBorder p-2">
                    <div class="row buildingInformationSection justify-content-center">
                        <div class="col-12 d-flex justify-content-center align-items-center flex-row">
                            <div class="font-weight-bold font-size-3">
                                Buildings Overview
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                            <img src="/images/gamePage/zoneImages/buildingLayers/fence.png">
                        </div>
                        <div class="col-12">
                            Life is fleeting in these arctic wastelands, but there's still the chance for a willful player to make their mark on the world. With enough determination (and possibly some teamwork) buildings can be created to improve your survival, design better items and even change the world around you.<br><br>At the same time you may find the need to defend yourself from those who would use your success for their own gain...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>createBuildingsPage()</script>