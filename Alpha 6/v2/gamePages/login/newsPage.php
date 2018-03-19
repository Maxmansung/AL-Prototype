<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div id="newsWindow">
    <div class="row justify-content-center mb-4">
        <div class="login-window col-lg-10 col-11 mt-3 pb-3">
            <div class="row col-12 justify-content-between align-items-center p-0 mt-3">
                <hr class="col-2" style="width: 100%; color: white; height: 1px; background-color:white;">
                <h1 class="funkyFont grayColour">News</h1>
                <hr class="col-2" style="width: 100%; color: white; height: 1px; background-color:white;">
            </div>
            <div id="newsStories">
            </div>
        </div>
    </div>
</div>