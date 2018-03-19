<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="login-window mt-3 col-12 col-md-5">
    <div class="d-flex flex-row justify-content-between align-items-baseline">
        <div class="funkyFont font-size-4">Achievements</div>
        <div class="clickableFlash funkyFont" onclick="achievementsViewChange()">Switch</div>
    </div>
    <div id="achievementWrapperMainOuter" class="mb-3">
        <div class="justify-content-center d-flex flex-row">
            <div id="achievementShownType" class="funkyFont font-size-3">Main</div>
        </div>
        <div id="achievementWrapperMain" class="d-flex flex-row flex-wrap align-items-center justify-content-center p-1 achievementWrapperInner">
        </div>
    </div>
    <div id="achievementWrapperSpeedOuter" class="mb-3">
        <div class="justify-content-center d-flex flex-row">
            <div id="achievementShownType" class="funkyFont font-size-3">Speed</div>
        </div>
        <div id="achievementWrapperSpeed" class="d-flex flex-row flex-wrap align-items-center justify-content-center p-1 achievementWrapperInner">
        </div>
    </div>
</div>