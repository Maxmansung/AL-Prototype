<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<script src="/js/leaderboard.js"></script>
<div class="container-fluid pb-3 pageSize">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-11 standardWrapper mt-5">
            <div class="row p-4 font-size-4">
                <div class="font-size-2x funkyFont align-items-center font-weight-bold font-size-3"><i class="fab fa-fort-awesome mr-3"></i>The Favoured</div>
            </div>
            <div class="row justify-content-around">
                <div class="col-1 d-md-block d-none"></div>
                <div class="col-3 col-lg-2 leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2 mt-3" align="center" onclick="goToPage('score&s=1')">
                    <div class="font-size-4"><i class="fas fa-snowflake"></i></div>
                    <div class="font-size-3 font-weight-bold">Cold Gods</div>
                    <div class="font-size-2 d-none d-sm-block">Those that live alone</div>
                </div>
                <div class="col-3 col-lg-2 leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2 mb-3" align="center" onclick="goToPage('score&s=2')">
                    <div class="font-size-4"><i class="fas fa-bomb"></i></div>
                    <div class="font-size-3 font-weight-bold">War Gods</div>
                    <div class="font-size-2 d-none d-sm-block">Those that team up against others</div>
                </div>
                <div class="col-3 col-lg-2 leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2 mt-3" align="center" onclick="goToPage('score&s=3')">
                    <div class="font-size-4"><i class="fas fa-leaf"></i></div>
                    <div class="font-size-3 font-weight-bold">Life Gods</div>
                    <div class="font-size-2 d-none d-sm-block">Those that unite the worlde</div>
                </div>
                <div class="col-1 d-md-block d-none"></div>
            </div>
            <div class="row justify-content-center my-3">
                <div class="grayTransparentBackground col-11 col-md-10">
                <?php
                if (isset($_GET["s"])) {
                    $score = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["s"]);
                    include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/leaderboard/leaderboardScore.php");
                } else {
                    include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/leaderboard/leaderboardIntro.php");
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>