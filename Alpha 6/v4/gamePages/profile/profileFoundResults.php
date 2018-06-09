<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row mx-md-0 mx-2 mb-3 mt-md-0 mt-3 justify-content-center">
    <div class="standardWrapper profilesFoundWrapper col-12">
        <div class="row justify-content-center">
            <div class="col-10 font-size-3 font-weight-bold standardWrapperTitle mb-2" align="center">
                Search Results
            </div>
        </div>
        <div class="profilesFound row justify-content-center">

        </div>
    </div>
</div>
