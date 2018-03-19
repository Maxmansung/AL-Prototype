<?php
?>
<div class="col-lg-7 col-md-6 py-4" id="forumThreadsPost">
    <div class="row col-12 blackColour threadTitlePosts">
        Thread Title here
    </div>
    <div class="row pl-3" id="forumPostAllWrapperLarge">
    </div>
    <div class="row textBoxPost" id="textBoxPostLarge">
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPostTextbox.php");
    ?>
    </div>
    <div class="col-12 mt-3 row justify-content-end">
        <button class="btn btn-dark btn-sm">Watch</button><div class="ml-3" id="postButtonLarge"><button class="btn btn-dark btn-sm" onclick="showTextBox()">Reply</button></div>
    </div>
    <div class="forumPostDirectionButtons row col-12 justify-content-between font-size-2 align-items-center">
    </div>
</div>
