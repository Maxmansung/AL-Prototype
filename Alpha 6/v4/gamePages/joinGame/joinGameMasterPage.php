<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-md-11 col-12 row p-0 justify-content-center d-flex flex-row-reverse">
        <div class="col-md-6 col-sm-10 col-10 standardWrapper mt-3">
            <div class="row justify-content-around">
                <div class="standardWrapperTitle font-size-2x col-11 my-2 pb-2 justify-content-between d-flex flex-row align-items-center">
                    <div>Join Game</div>
                    <i class="fas fa-map-marker-alt font-size-2x"></i>
                </div>
            </div>
            <div class="row justify-content-center" id="joinGameListWrapper">
            </div>
        </div>
        <div class="col-1 d-md-flex d-none">

        </div>
        <div class="col-md-5 col-sm-10 col-10 standardWrapper mt-3">
            <div class="row justify-content-center ">
                <div class="standardWrapperTitle font-size-2x col-11 my-2 pb-2 justify-content-between d-flex flex-row align-items-center">
                    <div>Important Links</div>
                    <i class="fas fa-star font-size-2x"></i>
                </div>
            </div>
            <div class="row justify-content-center" id="importantLinksWrapper">
            </div>
        </div>
        <div class="col-md-12 col-sm-10 col-10 standardWrapper mt-3">
            <div class="row justify-content-center ">
                <div class="standardWrapperTitle font-size-2x col-11 my-2 pb-2 justify-content-between d-flex flex-row align-items-center">
                    <div>News</div>
                    <i class="far fa-newspaper font-size-2x"></i>
                </div>
            </div>
            <div class="row justify-content-center" id="newsListWrapper">

            </div>
        </div>
    </div>
</div>
<script src="/js/joinGamePage.js"></script>
<script>getJoingameInfo()</script>