<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
    <div class="row py-2 justify-content-center">
        <div class="col-lg-9 col-11 d-md-block d-none blackColour font-size-4 font-weight-bold my-5 px-0"><i class="fas fa-envelope mr-4"></i>Welcome to Arctic Lands Forums</div>
        <div class="col-9 d-md-none d-sm-block d-none blackColour font-size-4 font-weight-bold my-4"><i class="fas fa-envelope mr-3"></i>Arctic Lands Forums</div>
        <div class="col-11 d-sm-none d-block blackColour font-size-3 font-weight-bold my-3"><i class="fas fa-envelope mr-3"></i>Arctic Lands Forums</div>
    </div>
    <div class="row justify-content-center d-sm-flex d-none">
        <div class="row col-md-11 col-lg-9 col-12 p-0 mb-5 justify-content-md-between justify-content-center">
            <div class="container col-md-3 col-sm-9 col-11 blackColour mb-md-0 mb-3 p-0 mx-0 hoverForumWrap" id="g" onclick="goToForum(this.id)">
                <div class="col-12 forumTypeImage d-flex flex-row justify-content-center align-items-center font-size-4"><i class="fas fa-globe font-size-4"></i></div>
                <div class="forumTypeText row col-12 mx-0 px-0 py-2">
                    <div class="font-size-3 col-12">General</div>
                    <div class="font-size-2 col-12">Arctic Lands general discussion</div>
                </div>
            </div>
            <?php
            if ($profile->getGameStatus() !== "in"){
                echo '<div class="container col-md-3 col-sm-9 col-11 blackColour mb-md-0 mb-3 p-0 mx-0 hoverForumWrapDisabled">
                <div class="col-12 forumTypeImage d-flex flex-row justify-content-center align-items-center font-size-4"><i class="fas fa-map font-size-4 grayColour"></i></div>
                <div class="forumTypeText row col-12 mx-0 px-0 py-2">
                    <div class="font-size-3 col-12">Map Chat</div>
                    <div class="font-size-2 col-12">This is only available whilst in a game</div>
                </div>
            </div>
            <div class="container col-md-3 col-sm-9 col-11 blackColour mb-md-0 mb-3 p-0 mx-0 hoverForumWrapDisabled">
                <div class="col-12 forumTypeImage d-flex flex-row justify-content-center align-items-center font-size-4"><i class="fas fa-users font-size-4 grayColour"></i></div>
                <div class="forumTypeText row col-12 mx-0 px-0 py-2">
                    <div class="font-size-3 col-12">Party Chat</div>
                    <div class="font-size-2 col-12">This is only available whilst in a game</div>
                </div>
            </div>';
            } else {
                echo '<div class="container col-md-3 col-sm-9 col-11 blackColour mb-md-0 mb-3 p-0 mx-0 hoverForumWrap" id="mc" onclick="goToForum(this.id)">
                <div class="col-12 forumTypeImage d-flex flex-row justify-content-center align-items-center font-size-4"><i class="fas fa-map font-size-4"></i></div>
                <div class="forumTypeText row col-12 mx-0 px-0 py-2">
                    <div class="font-size-3 col-12">Map Chat</div>
                    <div class="font-size-2 col-12">Shout out to those in game with you, but be careful what you tell them..</div>
                </div>
            </div>
            <div class="container col-md-3 col-sm-9 col-11 blackColour mb-md-0 mb-3 p-0 mx-0 hoverForumWrap" id="pc" onclick="goToForum(this.id)">
                <div class="col-12 forumTypeImage d-flex flex-row justify-content-center align-items-center font-size-4"><i class="fas fa-users font-size-4"></i></div>
                <div class="forumTypeText row col-12 mx-0 px-0 py-2">
                    <div class="font-size-3 col-12">Party Chat</div>
                    <div class="font-size-2 col-12">Plan, scheme, debate and argue as required here</div>
                </div>
            </div>';
            }
            ?>
        </div>
    </div>
    <div class="row justify-content-center d-md-none d-block">
        <div class="container justify-content-center">
            <div class="container row blackColour mb-3 mx-0 p-0 forumPhoneHeight" id="g" onclick="goToForum(this.id)">
                <div class="col-3 d-flex flex-row justify-content-center align-items-center forumTypeImagePhone"><i class="fas fa-globe font-size-4"></i></div>
                <div class="col-9 mx-0 px-0 py-2 forumTypeTextPhone">
                    <div class="font-size-3 col-12">General</div>
                    <div class="font-size-2 col-12">Arctic Lands general discussion</div>
                </div>
            </div>
<?php
if ($profile->getGameStatus() !== "in") {
    echo '<div class="container row blackColour mb-3 mx-0 p-0 forumPhoneHeightDisabled">
                <div class="col-3 d-flex flex-row justify-content-center align-items-center forumTypeImagePhone"><i class="fas fa-map font-size-4 grayColour"></i></div>
                <div class="col-9 mx-0 px-0 py-2 forumTypeTextPhone">
                    <div class="font-size-3 col-12">Map Chat</div>
                    <div class="font-size-2 col-12">This is only available whilst in a game</div>
                </div>
            </div>
            <div class="container row blackColour mb-3 mx-0 p-0 forumPhoneHeightDisabled">
                <div class="col-3 d-flex flex-row justify-content-center align-items-center forumTypeImagePhone"><i class="fas fa-users font-size-4 grayColour"></i></div>
                <div class="col-9 mx-0 px-0 py-2 forumTypeTextPhone">
                    <div class="font-size-3 col-12">Party Chat</div>
                    <div class="font-size-2 col-12">This is only available whilst in a game</div>
                </div>
            </div>';
} else {
    echo '<div class="container row blackColour mb-3 mx-0 p-0 forumPhoneHeight" id="mc" onclick="goToForum(this.id)">
                <div class="col-3 d-flex flex-row justify-content-center align-items-center forumTypeImagePhone"><i class="fas fa-map font-size-4"></i></div>
                <div class="col-9 mx-0 px-0 py-2 forumTypeTextPhone">
                    <div class="font-size-3 col-12">Map Chat</div>
                    <div class="font-size-2 col-12">Shout out to those in game with you, but be careful what you tell them..</div>
                </div>
            </div>
            <div class="container row blackColour mb-3 mx-0 p-0 forumPhoneHeight" id="pc" onclick="goToForum(this.id)">
                <div class="col-3 d-flex flex-row justify-content-center align-items-center forumTypeImagePhone"><i class="fas fa-users font-size-4"></i></div>
                <div class="col-9 mx-0 px-0 py-2 forumTypeTextPhone">
                    <div class="font-size-3 col-12">Party Chat</div>
                    <div class="font-size-2 col-12">Plan, scheme, debate and argue as required here</div>
                </div>
            </div>';

}
    ?>
        </div>
    </div>
    <div class="row justify-content-center mb-md-5 mb-3">
        <div class="col-11 col-sm-9 col-md-11 col-lg-9 forumRulesWrap blackColour">
            <div class="row font-size-3 mx-2">Rules</div>
            <div class="row ml-4 mr-2 mb-3" id="rulesText">
                1. Please avoid swearing and abusive language, this forum and game are not age limited
                <br>
                <br>
                2. Please use English in the forums, this is an English speaking game
                <br>
                <br>
                3. No text speak or shorthand where possible, communication should be clear to all
                <br>
                <br>
                4. No double posting, if you've got something to say then just say it once
            </div>
        </div>
    </div>
