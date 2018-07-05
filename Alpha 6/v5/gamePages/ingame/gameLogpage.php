<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row">
    <div class="col-12 standardWrapper d-none infoWrapLog">
        <div class="row py-2 justify-content-center">
            <div class="col-11 blackBackground whiteColour">
                <div class="row">
                    <div class="col-2 col-md-1 border whiteBorder" align="center">Time</div>
                    <div class="col-10 col-md-11 border whiteBorder" align="center">Action</div>
                </div>
            </div>
            <div class="zoneLogsWrapper col-11">
                <div class="row">
                    <div class="col-2 border blackBorder resize-font-size-1">12:21</div>
                    <div class="col-10 border blackBorder resize-font-size-1">This is where the writing will go about things that happen in a zone and stuff</div>
                </div>
            </div>
        </div>
    </div>
</div>