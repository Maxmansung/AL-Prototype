<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="position-fixed container-fluid login-window" id="signupPopupWindow" onclick="closeClick()">
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-5 col-11 loginWrapper mt-5 blockProp">
            <div class="row mt-2 justify-content-center" onclick="clickSignin()">
                <div class="blackColour font-size-2 clickableFlashMore font-weight-bold"><?php echo $text->signupScreenLoginLink() ?></div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="text" class="form-control" id="usernameSign" placeholder="<?php echo $text->signupScreenUsernamePlaceholder() ?>" autofocus>
                    <div class="input-group-prepend clickable" data-toggle="collapse" data-target="#usernameSignHelpBlock" aria-expanded="false" aria-controls="#usernameSignHelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="usernameSignError"><?php echo $text->signupScreenUsername() ?></div>
                    <small id="usernameSignHelpBlock" class="form-text grayColour collapse">
                        <?php echo $text->signupScreenUsernameDetails() ?>
                    </small>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="email" class="form-control" id="email" placeholder="<?php echo $text->signupScreenEmailPlaceholder() ?>">
                    <div class="input-group-prepend clickable" data-toggle="collapse" data-target="#emailHelpBlock" aria-expanded="false" aria-controls="#emailHelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="emailError"><?php echo $text->signupScreenEmail() ?></div>
                    <small id="emailHelpBlock" class="form-text grayColour collapse">
                        <?php echo $text->signupScreenEmailDetails() ?>
                    </small>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="password" class="form-control" id="password1" placeholder="<?php echo $text->signupScreenPasswordPlaceholder() ?>">
                    <div class="input-group-prepend clickable" data-toggle="collapse" data-target="#password1HelpBlock" aria-expanded="false" aria-controls="#password1HelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="password1Error"><?php echo $text->signupScreenPassword() ?></div>
                    <small id="password1HelpBlock" class="form-text grayColour collapse">
                        <?php echo $text->signupScreenPasswordDetails() ?>
                    </small>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="password" class="form-control" id="password2" placeholder="<?php echo $text->signupScreenPassword2Placeholder() ?>">
                    <div class="input-group-prepend clickable" id="usernameSignInfo" data-toggle="collapse" data-target="#password2HelpBlock" aria-expanded="false" aria-controls="#password2HelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="password2Error"><?php echo $text->signupScreenPassword2() ?></div>
                    <small id="password2HelpBlock" class="form-text grayColour collapse">
                        <?php echo $text->signupScreenPassword2Details() ?>
                    </small>
                </div>
            </div>
            <div class="form-group row justify-content-center mt-3">
                <div class="col-5">
                    <button type="button" class="btn btn-dark col-12 btn-sm" onclick="signupButton()" id="signupButton"><?php echo $text->signupScreenConfirm() ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
