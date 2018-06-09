 <?php
 if (isset($accessed) === false){
     header("location:/");
     exit("No access");
 }
?>
<div class="col-12 col-md-6 standardWrapper order-0 order-md-1 mb-3 mb-md-0">
    <div class="col-12 pr-5 mt-2 mx-0 d-flex d-md-none">
        <div class="clickableFlashMore d-flex justify-content-end" onclick="phoneBackPost()">
            <b><i class="fas fa-reply"></i>Back</b>
        </div>
    </div>
    <div class="row col-12 pt-3 pb-2 ml-3 px-0 threadTitlePosts font-size-2x font-weight-bold">
        Thread Title here
    </div>
    <div class="forumPostDirectionButtonsWrapper row py-0 mx-md-4 mx-2 my-2 align-items-center">
        <div class="col-5 font-size-2 d-flex flex-row font-weight-bold"><div class="clickableLink pr-3" onclick="showTextBox()">ANSWER</div><div class="clickableLink">FOLLOW</div></div>
        <div class="col-7 forumPostDirectionButtons d-flex justify-content-between font-size-2 align-items-center "></div>
    </div>
    <div class="row pl-3" id="forumPostAllWrapper">
    </div>
    <div class="row textBoxPost mt-3" id="textBoxPostLarge">
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/templates/insertTextBox.php");
    ?>
    </div>
    <div class="row justify-content-around mt-2" id="postButton"></div>
    <div class="forumPostDirectionButtonsWrapper row py-0 mx-md-4 mx-2 my-2 align-items-center">
        <div class="col-5 blackColour font-size-2 d-flex flex-row font-weight-bold"><div class="clickableLink pr-3" onclick="showTextBox()">ANSWER</div><div class="clickableLink">FOLLOW</div></div>
        <div class="col-7 forumPostDirectionButtons d-flex justify-content-between font-size-2 align-items-center "></div>
    </div>
</div>
