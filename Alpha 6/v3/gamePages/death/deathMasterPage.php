<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<script src="/js/deathScreen.js"></script>
<div class="container-fluid pb-3 pageSize">
    <div class="row d-flex justify-content-center align-items-center mt-5">
        <div class="col-11 col-sm-8 col-lg-6 standardWrapper py-2">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 funkyFont font-size-6" align="center">
                    You died!
                </div>
                <div class="col-12 font-size-2" align="center">on</div>
                <div class="col-12 font-size-2x font-weight-bold deathPageMapName" align="center"></div>
                <div class="col-12 col-sm-10 col-lg-8 tempImageDeath d-flex flex-column justify-content-center align-items-center my-2">
                    <div class="font-size-3 font-weight-bold deathPageCause" align="center"></div>
                    <div class="font-size-2 description deathPageDescription" align="center"></div>
                    <span class="font-size-2 mt-4">Image Here</span>
                </div>
            </div>
            <div class="row justify-content-center flex-column">
                <div align="center">Days Survived</div>
                <div class="font-size-6 font-weight-bold p-0 deathPageDays" align="center"></div>
            </div>
            <div class="row justify-content-around flex-row">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="font-size-4 font-weight-bold"><span class="deathPageNightTemp"></span><span>&degC</span></div>
                    <div class="font-size-2" align="center">Night<br>Temperature</div>
                </div>
                <div class="d-flex flex-column">
                    <div class="font-size-4 font-weight-bold"><span class="deathPageSurvTemp"></span><span>&degC</span></div>
                    <div class="font-size-2" align="center">Survivable<br>Temperature</div>
                </div>
            </div>
            <div class="row justify-content-center py-2">
                <div class="col-10 horizontalLine"></div>
            </div>
            <div class="row justify-content-center">
                <div class="font-size-3 font-weight-bold">Gods Favour</div>
            </div>
            <div class="row justify-content-center">
                <div class="col-10 font-size-2 my-2" align="center">
                    Each night that you were a gods favoured champion you gained points with them equal to the days you had survived until then. <br>This favour is remembered by the gods and recorded on your soul.
                </div>
            </div>
            <div class="row justify-content-center my-2 deathPageTopGod">
            </div>
            <div class="row justify-content-around my-2 deathPageBottomGod">
            </div>
            <div class="row justify-content-center">
                <div class="col-10 font-size-2 my-2" align="center">
                    You can see the gods most favoured champions on the leaderboards page
                </div>
            </div>
            <div class="row justify-content-center py-2">
                <div class="col-10 horizontalLine"></div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-11">
                    <div class="row justify-content-center">
                        <div class="font-size-3 font-weight-bold">Achievements</div>
                    </div>
                    <div class="row d-flex flex-row justify-content-center align-items-center flex-wrap standardWrapper deathPageAchievementWrapper">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center py-4">
                <button class="btn btn-danger" onclick="confirmDeath()">Acknowledge Death</button>
            </div>
        </div>
    </div>
</div>
<script>getPageInfo()</script>