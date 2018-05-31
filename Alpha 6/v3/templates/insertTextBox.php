<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="col-12">
    <div class="col-12 blackColour p-2 d-flex flex-row font-weight-bold" id="forumPostHeader">
        <div class="clickableFlashMore px-2 keepSelection" onclick="addTextFormat('****')">B</div>
        <div class="clickableFlashMore px-2 keepSelection" onclick="addTextFormat('////')">I</div>
        <div class="clickableFlashMore px-2 keepSelection" onclick="addTextFormat('^^^^')">RP</div>
        <div class="clickableFlashMore px-2 keepSelection" onclick="showEmojis()">Emoji</div>
    </div>
    <div class="col-12 collapse" id="emojiWrapper">
        <div class="d-flex flex-row flex-wrap" id="emojiList">

        </div>
    </div>
</div>
<div class="col-12">
    <textarea class="col-12 form-control" data-limit-rows="true" rows="30" id="postBoxTextbox"></textarea>
</div>
<script>createEmojiLine()</script>