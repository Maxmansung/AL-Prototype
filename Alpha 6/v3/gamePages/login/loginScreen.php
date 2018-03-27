<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="position-fixed container-fluid login-window" id="loginPopupWindow" onclick="closeClick()">
    <div class="row blackColour justify-content-center">
        <div class="col-lg-3 col-md-5 col-11 loginWrapper mt-5 blockProp">
            <div class="row justify-content-center mt-3">
                <button class="btn btn-dark" onclick="clickRegister()"><?php echo $text->loginScreenSignup();?></button>
            </div>
            <div class="row mt-3 justify-content-center">
                <?php echo $text->loginScreenConnect();?>
            </div>
            <div class="row mt-1 justify-content-center">
                <div class="col-11 d-flex flex-column">
                    <input type="text" class="form-control" id="username" placeholder="<?php echo $text->loginScreenUsernamePlaceholder();?>" autofocus>
                    <div class="invalid-feedback" id="usernameError"><?php echo $text->loginScrenUsername();?></div>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11  d-flex flex-column">
                    <input type="password" class="form-control" id="password" placeholder="<?php echo $text->loginScreenPasswordPlaceholder();?>">
                    <div class="invalid-feedback" id="passwordError"><?php echo $text->loginScreenPassword();?></div>
                </div>
            </div>
            <div class="row mt-2 justify-content-end">
                <a class="clickableLink" onclick="clickForgotten()"><?php echo $text->loginScreenForgottenPassword();?></a>
                <div class="col-1"></div>
            </div>
            <div class="row mt-1">
                <div class="col-1"></div>
                <div class="form-check">
                    <input type="checkbox" id="rememberMe" class="form-check-input" />
                    <label class="form-check-label small" for="rememberMe"><?php echo $text->loginScreenRememberMe();?></label>
                </div>
            </div>
            <div class="form-group row justify-content-center mt-3">
                <div class="col-5">
                    <button type="button" class="btn btn-dark col-12 btn-sm" onclick="loginButton()" id="loginButton"><?php echo $text->loginScreenConfirm();?></button>
                </div>
            </div>
        </div>
    </div>
</div>