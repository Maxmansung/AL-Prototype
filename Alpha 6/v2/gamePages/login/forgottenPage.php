<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div id="forgottenPasswordScreen">
    <div class="row justify-content-center flex-wrap">
        <div class="col-lg-3 col-md-5 col-11 login-window my-3">
            <div class="row pl-3">
                <button class="btn btn-dark btn-sm" onclick="clickSignin()">X</button>
            </div>
            <div class="row mt-3 justify-content-center">
                <span class="font-size-2 grayColour">Please type the email used to create your account</span>
            </div>
            <div class="row mt-1 justify-content-center">
                <div class="col-11 d-flex flex-column">
                    <input type="text" class="form-control" id="emailForgot" placeholder="Email Address" autofocus>
                    <div class="invalid-feedback" id="emailForgotAddress">Email Address</div>
                </div>
            </div>
            <div class="form-group row justify-content-center mt-3">
                <div class="col-6">
                    <button type="button" class="btn btn-dark col-12 btn-sm" id="reminderButton" onclick="forgottenPassword()">Send reminder!</button>
                </div>
            </div>
            <div class="row mt-1 justify-content-center font-size-2 grayColour">
                ----- Or -----
            </div>
            <div class="row mb-1 justify-content-center">
                <a href="mailto:admin@arctic-lands.com?Subject=Login%20Help&body=Please help me with my account!%0D%0A%0D%0AMy username is: <Insert Username>%0D%0A%0D%0AI think my email address is: <Insert Email Address>%0D%0A%0D%0AThe problem I'm having is: <Insert problem here>" class="loginLink" >Contact the admins</a>
            </div>
        </div>
        <div class="col-md-1 d-none d-md-block"></div>
        <div class="col-md-5 col-11 login-window my-3">
            <h1 class="grayColour funkyFont m-3">Memories fade...</h1>
            <p class="grayColour small m-3">You wake up in the snow again, unsure of where you are or whats around. All you know is that you're dead. <br><br>Turns out there is an afterlife, unfortunately that afterlife is a never ending cycle of dying and being reborn in the empty wastelands.<br><br>Can you do enough to please the gods of this hell and eventually find peace?</p>
        </div>
    </div>
</div>