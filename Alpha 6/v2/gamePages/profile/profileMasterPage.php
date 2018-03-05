<?php
?>
<script src="/js/profilePage.js"></script>
<div class="container">
    <div class="row">
        <div class="login-window mt-3 col-12 col-md-5">
            <div class="my-3 mx-1 d-flex flex-row">
                <div class="profileImage">
                    <img src="/avatarimages/Unknown.png" class="avatarImage" id="profilePageImage">
                </div>
                <div class="d-flex flex-column mx-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div class="funkyFont font-size-3" id="profilePageName">

                        </div>
                        <div class="flagImage">
                            <img src="https://www.arctic-lands.com/images/flags/United%20Kingdom.png" id="profilePageFlag">
                        </div>
                    </div>
                    <div class="font-size-2" id="profilePageBio"></div>
                </div>
            </div>
            <div class="row mx-1 justify-content-between align-items-baseline mb-2">
                <div class="font-size-1">
                    Last login:
                    <span id="profilePageLogin"></span>
                </div>
                <div class="font-size-1">
                    Gender:
                    <span id="profilePageGender"></span>
                </div>
                <div class="font-size-1">
                    Age:
                    <span id="profilePageAge"></span>
                </div>
                <div class="clickable">
                    <i class="fas fa-edit"></i>
                </div>
            </div>
        </div>
        <div class="login-window mt-3 mx-md-3 col-12 col-md-5">
            <div class="funkyFont font-size-4 align-self-center">Achievements</div>
            <div id="achievementWrapperMain" class="d-flex flex-row flex-wrap align-items-center justify-content-center p-1 my-3">
                <div class="singleAchievementWrapper" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                    <img src="/images/achievements/campingDirt.png" class="achievementImage">
                    <div class="achievementCounter font-size-1">
                        234
                    </div>
                </div>
            </div>
            <div id="achievementWrapperSpeed" class="d-flex flex-row flex-wrap align-items-center justify-content-center p-1 my-3">
                <div class="singleAchievementWrapper" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                    <img src="/images/achievements/campingDirt.png" class="achievementImage">
                    <div class="achievementCounter font-size-1">
                        234
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(isset($_GET["p"])){
    $person = $_GET["p"];
} else {
    $person = $profile->getProfileID();
}
echo "<div class='d-none getDataClass'  id='".$person."'></div>"
?>
<script>
    var data = $(".getDataClass").attr('id');
    ajax_All(35,2,data)
</script>
