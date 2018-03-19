<?php
?>
<div class="row p-2 m-2 justify-content-center" id="forumThreadPostPhone">
    <div class="col-12  p-0 m-0">
        <div class="blackColour clickableFlashMore" onclick="phoneBackPost()">
            <b><i class="fas fa-reply"></i>Back</b>
        </div>
    </div>
    <div class="col-12 p-0 m-0" id="forumPostAllWrapperPhone">
    </div>
    <div class="row textBoxPost" id="textBoxPostPhone">
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPostTextbox.php");
    ?>
    </div>
    <div class="col-12 row justify-content-end">
        <button class="btn btn-dark btn-sm">Watch</button><div class="ml-3" id="postButtonPhone"><button class="btn btn-dark btn-sm" onclick="showTextBox()">Reply</button></div>
    </div>
    <div class="col-12">
        <div class="forumPostDirectionButtons row justify-content-between align-items-center font-size-2">
        </div>
    </div>
</div>
