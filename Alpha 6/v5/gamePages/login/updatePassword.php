<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
echo "<div class='d-none getDataClass'  id='".$_GET['u']."'></div>";
echo "<div class='d-none getDataClass2'  id='".$_GET['p']."'></div>";
?>
<script src="/js/passwordRecovery.js"></script>
<div class="container-fluid">
    <div class="row pt-md-5">
    </div>
    <div class="row justify-content-center py-5">
        <div class="col-md-8 col-lg-6 col-sm-10 col-11 standardWrapper">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 funkyFont font-size-5" align="center">
                    Forgotten who you are?
                </div>
            </div>
            <div class="row pt-5 justify-content-center">
                <div class="col-11" align="center">
                    Dont worry, the gods remember you at least<br>Just type in a new password and get back to not living!
                </div>
            </div>
            <div class="row justify-content-center pt-5 pb-3">
                <div class="col-11 col-sm-8 col-md-8 col-xl-6">
                        <input type="password" class="form-control" placeholder="Password" aria-label="Password" id="forgottenPassword1">
                    <div class="invalid-feedback" id="forgottenPassword1Error">Please type a password</div>
                </div>
            </div>
            <div class="row justify-content-center pt-3 pb-3">
                <div class="col-11 col-sm-8 col-md-8 col-xl-6">
                    <input type="password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password" id="forgottenPassword2">
                    <div class="invalid-feedback" id="forgottenPassword2Error">Please type a password</div>
                </div>
            </div>
            <div class="row justify-content-center pb-5">
                <button class="btn btn-primary" id="submitPasswordForgotten" onclick="recoverPassword()">Submit</button>
            </div>
        </div>
    </div>
</div>
<script>getListenerPassword()</script>