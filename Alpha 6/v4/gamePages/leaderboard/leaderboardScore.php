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
    <div class="col-11 leaderboardScoreWrapper">
    </div>
</div>
<script>getScores()</script>