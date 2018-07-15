<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
echo "<div class='d-none getDataClass'  id='".$score."'></div>"
?>
<div class="row justify-content-center">
    <div class="col-11 font-size-3 font-weight-bold p-3" align="center" id="leaderboardTitleName"></div>
</div>
<div class="row justify-content-center px-0 py-4">
    <div class="col-11 mb-2">
        <div class="row justify-content-around" id="leaderboardTopRanks">
        </div>
    </div>
    <div class="col-11">
        <div class="row font-size-2 grayColour borderTopBottom lightGrayBorder py-1 mb-2">
            <div class="col-2 col-md-3 d-flex justify-content-center" align="center">
                <div class="d-none d-sm-block">
                    POSITION
                </div>
                <div class="d-block d-sm-none">
                    POS.
                </div>
            </div>
            <div class="col-7 col-md-6 d-flex justify-content-center" align="center">
                PLAYER
            </div>
            <div class="col-3 col-md-3 d-flex justify-content-center" align="center">
                POINTS
            </div>
        </div>
    </div>
    <div class="col-11 leaderboardScoreWrapper">
    </div>
</div>
<script>getScores()</script>