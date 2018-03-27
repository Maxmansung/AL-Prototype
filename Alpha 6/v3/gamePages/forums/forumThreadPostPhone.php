<?php
?>
<div class="col-12 p-2 m-2 justify-content-center standardWrapper" id="forumThreadPostPhone">
    <div class="col-12 pr-5 m-0">
        <div class="clickableFlashMore d-flex justify-content-end" onclick="phoneBackPost()">
            <b><i class="fas fa-reply"></i>Back</b>
        </div>
    </div>
    <div class="row col-12 pt-0 pb-2 ml-3 px-0 threadTitlePosts font-size-2x font-weight-bold">
        Thread Title here
    </div>
    <div class="forumPostDirectionButtonsWrapper row py-0 mx-2 my-2 align-items-center">
        <div class="col-5 font-size-2 d-flex flex-row font-weight-bold"><div class="clickableLink pr-3" onclick="showTextBox()">ANSWER</div><div class="clickableLink">FOLLOW</div></div>
        <div class="col-7 forumPostDirectionButtons d-flex justify-content-between font-size-2 align-items-center "></div>
    </div>
    <div class="col-12 p-0 m-0" id="forumPostAllWrapperPhone">
    </div>
    <div class="row textBoxPost mt-3" id="textBoxPostPhone">
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPostTextbox.php");
    ?>
    </div>
    <div class="row justify-content-center mt-2" id="postButtonPhone"></div>
    <div class="forumPostDirectionButtonsWrapper row py-0 mx-2 my-2 align-items-center">
        <div class="col-5 blackColour font-size-2 d-flex flex-row font-weight-bold"><div class="clickableLink pr-3" onclick="showTextBox()">ANSWER</div><div class="clickableLink">FOLLOW</div></div>
        <div class="col-7 forumPostDirectionButtons d-flex justify-content-between font-size-2 align-items-center "></div>
    </div>
</div>