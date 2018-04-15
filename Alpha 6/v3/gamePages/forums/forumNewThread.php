<?php
?>
<div class="col-md-6 col-12 font-size-2 standardWrapper p-3" id="forumNewThread">
    <div class="row justify-content-between p-3">
        <input class="col-5 form-control" type="text" id="postTitleCreate" placeholder="Title">
        <select class="col-3 form-control" id="postTypeCreate">
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
    <div class="row">
        <div class="col-11 justify-content-center mt-3 d-flex flex-row">
            <button class="btn btn-dark" onclick="createThreadLarge()">Create</button>
        </div>
    </div>
</div>
