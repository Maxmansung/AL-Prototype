<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="standardWrapper row mx-md-0 mx-2 mb-3 mt-md-0 mt-3 justify-content-center">
    <div class="col-10 standardWrapperTitle font-size-3 pt-2">
        Achievements
    </div>
    <div class="col-12 d-flex flex-row justify-content-center align-items-center pt-2">
        <div class="mx-2 font-weight-bold font-size-2x profilePageMainButton" onclick="achievementsViewChange(1)">Main</div>
        <div class="mx-2 clickableFlash profilePageSpeedButton" onclick="achievementsViewChange(0)">Speed</div>
    </div>
    <div class="col-10 grayBorder mb-3 rounded d-flex flex-row flex-wrap align-items-center justify-content-center profilePageMainAchieve">
    </div>
    <div class="col-10 grayBorder mb-3 rounded d-flex flex-row flex-wrap align-items-center justify-content-center profilePageSpeedAchieve">
    </div>
    <div class="col-10 standardWrapperTitle font-size-3 pt-2 mb-3">
            Favour Gained
    </div>
    <div class="col-10 lightGrayBackground mb-3 rounded">
        <div class="row justify-content-around align-items-center p-2">
            <div class="col-4 px-1">
                <div class="leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2 mt-3" align="center" id="soloScoreWrap" onclick="goToPage('score&s=1')">
                    <div class="font-size-4"><i class="fas fa-snowflake"></i></div>
                    <div class="font-size-2x font-weight-bold">Alone</div>
                    <div class="leaderboardNumber"></div>
                </div>
            </div>
            <div class="col-4 px-1">
                <div class="leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2 mb-3" align="center" id="teamScoreWrap" onclick="goToPage('score&s=2')">
                    <div class="font-size-4"><i class="fas fa-bomb"></i></div>
                    <div class="font-size-2x font-weight-bold">Clan</div>
                    <div class="leaderboardNumber"></div>
                </div>
            </div>
            <div class="col-4 px-1">
                <div class="leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2 mt-3" align="center" id="fullScoreWrap" onclick="goToPage('score&s=3')">
                    <div class="font-size-4"><i class="fas fa-leaf"></i></div>
                    <div class="font-size-2x font-weight-bold">Town</div>
                    <div class="leaderboardNumber"></div>
                </div>
            </div>
        </div>
    </div>
</div>