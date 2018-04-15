<?php
?>
<div class="row p-2 m-2 justify-content-center standardWrapper" id="forumNewThreadPhone">
    <div class="col-12 my-2">
        <div class="clickableFlashMore" onclick="phoneBackPost()">
            <b><i class="fas fa-reply"></i>Back</b>
        </div>
    </div>
    <div class="col-12">
        <input class="col-12 form-control mt-2" type="text" id="postTitleCreate" placeholder="Title">
        <select class="col-12 form-control mt-2" id="postTypeCreate">
            <option value="test">Important</option>
        </select>
        <?php
        if ($profile->getAccessEditForum()===1){
            echo '<div class="form-check col-3 align-items-center d-flex flex-row">
            <input class="form-check-input pb-3" type="checkbox" id="postStickyCreate">
            <label class="form-check-label blackColour" for="postStickyCreate">
                Sticky
            </label>
        </div>';
        }
        ?>
    </div>
    <div class="row textBoxThread">
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPostTextbox.php");
    ?>
    </div>
    <div class="col-12">
        <div class="col-12 justify-content-center mt-3 d-flex flex-row">
            <button class="btn btn-dark" onclick="createThreadPhone()">Create</button>
        </div>
    </div>
</div>
