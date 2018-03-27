<?php
?>
<div class="col-md-6 standardWrapper" id="forumThreadsPost">
    <div class="row col-12 pt-3 pb-2 ml-3 px-0 threadTitlePosts font-size-2x font-weight-bold">
        Thread Title here
    </div>
    <div class="forumPostDirectionButtonsWrapper row py-0 mx-4 my-2 align-items-center">
        <div class="col-5 font-size-2 d-flex flex-row font-weight-bold"><div class="clickableLink pr-3" onclick="showTextBox()">ANSWER</div><div class="clickableLink">FOLLOW</div></div>
        <div class="col-7 forumPostDirectionButtons d-flex justify-content-between font-size-2 align-items-center "></div>
    </div>
    <div class="row pl-3" id="forumPostAllWrapperLarge">
    </div>
    <div class="row textBoxPost mt-3" id="textBoxPostLarge">
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPostTextbox.php");
    ?>
    </div>
    <div class="row justify-content-center mt-2" id="postButtonLarge"></div>
    <div class="forumPostDirectionButtonsWrapper row py-0 mx-4 my-2 align-items-center">
        <div class="col-5 blackColour font-size-2 d-flex flex-row font-weight-bold"><div class="clickableLink pr-3" onclick="showTextBox()">ANSWER</div><div class="clickableLink">FOLLOW</div></div>
        <div class="col-7 forumPostDirectionButtons d-flex justify-content-between font-size-2 align-items-center "></div>
    </div>
</div>
