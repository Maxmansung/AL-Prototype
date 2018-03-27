<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="position-fixed container-fluid login-window" id="forgottenPopupWindow" onclick="closeClick()">
    <div class="row justify-content-center flex-wrap">
        <div class="col-lg-4 col-md-6 col-11 mt-5 p-3 loginWrapper blockProp">
            <div class="row mt-3 justify-content-center">
                <span class="font-size-2 blackColour"><?php echo $text->forgottenScreenDetails()?></span>
            </div>
            <div class="row mt-1 justify-content-center">
                <div class="col-11 d-flex flex-column">
                    <input type="text" class="form-control" id="emailForgot" placeholder="<?php echo $text->forgottenScreenEmailPlaceholder()?>" autofocus>
                    <div class="invalid-feedback" id="emailForgotAddress"><?php echo $text->forgottenScreenEmail()?></div>
                </div>
            </div>
            <div class="form-group row justify-content-center mt-3">
                <div class="col-6">
                    <button type="button" class="btn btn-dark col-12 btn-sm" id="reminderButton" onclick="forgottenPassword()"><?php echo $text->forgottenScreenConfirm()?></button>
                </div>
            </div>
            <div class="row mt-1 justify-content-center font-size-2 blackColour">
                <?php echo $text->forgottenScreenOr()?>
            </div>
            <div class="row mt-2 justify-content-center">
                <a href="<?php echo $text->forgottenScreenEmailPrep()?>" class="blackColour font-size-2 font-weight-bold clickableFlashMore" ><?php echo $text->forgottenScreenContact()?></a>
            </div>
        </div>
    </div>
</div>