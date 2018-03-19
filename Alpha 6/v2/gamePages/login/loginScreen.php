<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div id="loginWindowScreen">
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-5 col-11 login-window my-3">
            <div class="row justify-content-center mt-3">
                <button class="btn btn-dark" onclick="clickRegister()">Sign up now</button>
            </div>
            <div class="row mt-3 justify-content-center">
                or connect:
            </div>
            <div class="row mt-1 justify-content-center">
                <div class="col-11 d-flex flex-column">
                    <input type="text" class="form-control" id="username" placeholder="Username" autofocus>
                    <div class="invalid-feedback" id="usernameError">Enter username</div>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11  d-flex flex-column">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <div class="invalid-feedback" id="passwordError">Enter password</div>
                </div>
            </div>
            <div class="row mt-2 justify-content-end">
                <a class="loginLink" onclick="clickForgotten()">Forgotten Password?</a>
                <div class="col-1"></div>
            </div>
            <div class="row mt-1">
                <div class="col-1"></div>
                <div class="form-check">
                    <input type="checkbox" id="rememberMe" class="form-check-input" />
                    <label class="form-check-label small" for="rememberMe">Remember Me</label>
                </div>
            </div>
            <div class="form-group row justify-content-center mt-3">
                <div class="col-5">
                    <button type="button" class="btn btn-dark col-12 btn-sm" onclick="loginButton()" id="loginButton">Login</button>
                </div>
            </div>
        </div>
        <div class="col-md-1 d-none d-md-block "></div>
        <div class="col-lg-6 col-md-5 col-11 login-window my-3">
            <h1 class="grayColour funkyFont m-3">Its a wonderful afterlife...</h1>
            <div class="grayColour m-3">You wake up in the snow again, unsure of where you are or whats around. All you know is that you're dead. <br><br>Turns out there is an afterlife, unfortunately that afterlife is a never ending cycle of dying and being reborn in the empty wastelands.<br><br>Can you do enough to please the gods of this hell and eventually find peace?</div>
        </div>
    </div>
</div>
