<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="col-md-6 col-12 font-size-2 standardWrapper p-3 mb-3 mb-md-0">
    <div class="col-12 my-2 d-md-none d-flex">
        <div class="clickableFlashMore" onclick="phoneBackPost()">
            <b><i class="fas fa-reply"></i>Back</b>
        </div>
    </div>
    <div class="row justify-content-between p-3">
        <input class="col-12 col-md-5 form-control mt-2" type="text" id="postTitleCreate" placeholder="Title">
        <select class="col-12 col-md-3 form-control mt-2" id="postTypeCreate">
            <option value="test">Important</option>
        </select>
        <?php
        if ($profile->getAccessEditForum()===1){
            echo '<div class="form-check col-12 col-md-3 mt-md-0 mt-2 d-md-flex align-items-md-center">
            <input class="form-check-input" type="checkbox" id="postStickyCreate">
            <label class="form-check-label blackColour" for="postStickyCreate">
                Sticky
            </label>
        </div>';
        }
        ?>
    </div>
    <div class="row textBoxThread">
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/templates/insertTextBox.php");
    ?>
    </div>
    <div class="row">
        <div class="col-11 justify-content-center mt-3 d-flex flex-row">
            <button class="btn btn-dark" onclick="postNewThread()">Create</button>
        </div>
    </div>
</div>
