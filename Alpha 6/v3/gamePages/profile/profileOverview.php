<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row mx-md-0 mx-2 ">
    <div class="col-12 blackColour grayBorder">
        <div class="row justify-content-between lightGrayBackground">
            <div class="col-3 font-size-4 p-3">
                <i class="fas fa-cog clickableFlash" onclick="goToPage('edit')"></i>
            </div>
            <div class="col-6 col-sm-4 col-md-6 pt-4 pb-2 d-flex flex-row justify-content-center align-items-center">
                <img src="" class="rounded-circle profilePageImage">
            </div>
            <div class="col-3 d-flex flex-row justify-content-end align-items-start p-3">
                <img src="" class="flagImage profilePageFlag">
            </div>
        </div>
        <div class="row justify-content-center lightGrayBackground py-2">
            <div class="col-12 darkGrayColour font-size-2x profileSpiritType" align="center">
            </div>
        </div>
        <div class="row justify-content-center whiteBackground">
            <div class="col-12 font-weight-bold font-size-3 profileSpiritName pt-2" align="center">
            </div>
            <div class="col-8 d-flex flex-row justify-content-start grayColour font-size-2 standardWrapperTitle">
                <span class="pr-2">Last login: </span><span class="profilePageLogin"></span>
            </div>
        </div>
        <div class="row whiteBackground">
            <div class="col-12 py-2 px-4 profilePageBio" align="center">
            </div>
        </div>
        <div class="row lightGrayBackground">
            <div class="col-12 pl-4 py-2 font-weight-bold font-size-2x" align="left">
                Show off
            </div>
        </div>
        <div class="row">
            <div class="col-3 standardWrapper">
                <img src="/images/profilePage/achievements/hacker.png" class="achievementShowoff showOff1">
            </div>
            <div class="col-3 standardWrapper">
                <img src="/images/profilePage/achievements/hacker.png" class="achievementShowoff showOff2">
            </div>
            <div class="col-3 standardWrapper">
                <img src="/images/profilePage/achievements/hacker.png" class="achievementShowoff showOff3">
            </div>
            <div class="col-3 standardWrapper">
                <img src="/images/profilePage/achievements/hacker.png" class="achievementShowoff showOff4">
            </div>
        </div>
        <div class="row lightGrayBackground">
            <div class="col-12 d-flex p-3 flex-column justify-content-start">
                <div class="font-weight-bold font-size-2x">
                    Info
                </div>
                <div class="pl-3 d-flex flex-row">
                    <span class="pr-2">Gender: </span><span class="profilePageGender"></span>
                </div>
                <div class="pl-3">
                    <span class="pr-2">Age: </span><span class="profilePageAge"></span>
                </div>
            </div>
        </div>
    </div>
</div>