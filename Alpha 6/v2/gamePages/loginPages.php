<?php
?>
<div id="loginWindowScreen">
    <h1 id="titleWriting" align="center">Can you survive the Arctic Lands?</h1>
    <div class="container login-window px-3 py-4">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block lineOnRight">
                <h3>Its a wonderful afterlife...</h3>
                <p class="descriptionWriting">You wake up in the snow again, unsure of where you are or whats around. All you know is that you're dead. <br><br>Turns out there is an afterlife, unfortunately that afterlife is a never ending cycle of dying and being reborn in the empty wastelands.<br><br>Can you do enough to please the gods of this hell and eventually find peace?</p>
            </div>
            <form action="" class="col-lg-6 col-12">
                <div class="form-group   row" data-toggle="tooltip" data-placement="left" title="Username">
                    <label for="username" class="col-sm-3 col-form-label">USERNAME</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username"  autofocus>
                    </div>
                </div>
                <div class="form-group row" data-toggle="tooltip" data-placement="left" title="Password">
                    <label for="password" class="col-sm-3 col-form-label">PASSWORD</label>
                    <div class="col-sm-9 col-12">
                        <input type="password" class="form-control" id="password">
                    </div>
                </div>
                <div class="row align-content-center">
                    <p class="col-6" align="right">Remember Me</p>
                    <div class="material-switch pull-right col-6" align="left">
                        <input id="someSwitchOptionPrimary" name="someSwitchOption001" type="checkbox"/>
                        <label for="someSwitchOptionPrimary" class=""></label>
                    </div>
                </div>
                <div class="form-group row justify-content-sm-center">
                    <div class="col-lg-4 col-12">
                        <button type="button" class="btn btn-dark col-12" onclick="loginButton()">LOGIN</button>
                    </div>
                </div>
                <div class="row p-3" >
                    <a href="#" class="badge col signinLink">PASSWORD</a>
                    <div class="col-1 lineOnRight"></div>
                    <div class="col-1"></div>
                    <a href="#" class="badge col signinLink" onclick="clickRegister()">REGISTER</a>
                </div>
                <div class="row justify-content-center">
                    <p class="lineOnTop"></p>
                </div>
                <div class="row px-3 justify-content-between">
                    <button id="gSignInWrapper" class="btn btn-primary col-sm-6 col-12">
                        <div id="customBtn" class="customGPlusSignIn">
                            <span class="icon"><img id="googleIcon" src="/images/google/g-logo.png"> </span>
                            <span class="label buttonText" id="name">Google?</span>
                        </div>
                    </button>
                    <button class="btn btn-danger col-sm-6 col-12">Facebook?</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="signupWindowScreen">
    <h1 id="titleWriting" align="center">Enter the wilds</h1>
    <div class="container login-window px-3 py-4">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block lineOnRight">
                <h3>Register your death</h3>
                <p class="descriptionWriting">Today is the first day of the rest of your afterlife, role up and register your soul with the Grim Reaper.<br><br>But whats this? Your soul seems impure, unfavoured by any of the realms gods!<br><br>No, no no... this just wont do... it seems you will have some making up to do soon</p>
            </div>
            <form action="" class="col-lg-6 col-12">
                <div class="form-group row px-3" data-toggle="tooltip" data-placement="left" title="Username">
                    <label for="usernameSignup" class="col-sm-4 d-none d-sm-block control-label col-form-label">USERNAME</label>
                    <input type="text" class="form-control col-sm-8 is-valid" id="usernameSignup" placeholder="Username" autofocus>
                    <div class="invalid-feedback">Example invalid feedback text</div>
                </div>
                <div class="form-group row  px-3" data-toggle="tooltip" data-placement="left" title="Email Address">
                    <label for="email" class="col-sm-4 d-none d-sm-block col-form-label">EMAIL ADDRESS</label>
                    <input type="email" class="form-control col-sm-8" placeholder="Email Adress" id="email">
                </div>
                <div class="form-group row px-3" data-toggle="tooltip" data-placement="left" title="Password" >
                    <label for="password1" class="col-sm-4 d-none d-sm-block col-form-label ">PASSWORD</label>
                    <input type="password" class="form-control col-sm-8" placeholder="Password" id="password1">
                </div>
                <div class="form-group right-inner-addon row px-3" data-toggle="tooltip" data-placement="left" title="Repeat Password">
                    <label for="password2" class="col-sm-4 d-none d-sm-block col-form-label">PASSWORD</label>
                    <input type="password" class="form-control col-sm-8" placeholder="Confirm Password" id="password2">
                </div>
                <div class="form-group row justify-content-sm-center">
                    <div class="col-lg-4 col-12">
                        <button type="button" class="btn btn-dark col-12">REGISTER</button>
                    </div>
                </div>
                <div class="row p-3" >
                    <a href="#" class="badge col signinLink" onclick="clickSignin()">SIGN IN</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>displayPages()</script>
<script>startApp();</script>