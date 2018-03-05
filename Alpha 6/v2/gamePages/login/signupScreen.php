<?php
?>
<div id="signupWindowScreen">
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-5 col-11 login-window my-3">
            <div class="row mt-2 justify-content-center" onclick="clickSignin()">
                <div class="loginLink">Already registered?</div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="text" class="form-control" id="usernameSign" placeholder="Username" autofocus>
                    <div class="input-group-prepend clickable" data-toggle="collapse" data-target="#usernameSignHelpBlock" aria-expanded="false" aria-controls="#usernameSignHelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="usernameSignError">Enter username</div>
                    <small id="usernameSignHelpBlock" class="form-text grayColour collapse">
                        Usernames must not contain special characters
                    </small>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="email" class="form-control" id="email" placeholder="Email Address">
                    <div class="input-group-prepend clickable" data-toggle="collapse" data-target="#emailHelpBlock" aria-expanded="false" aria-controls="#emailHelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="emailError">Enter email address</div>
                    <small id="emailHelpBlock" class="form-text grayColour collapse">
                        Verification emails will be sent to this address
                    </small>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="password" class="form-control" id="password1" placeholder="Password">
                    <div class="input-group-prepend clickable" data-toggle="collapse" data-target="#password1HelpBlock" aria-expanded="false" aria-controls="#password1HelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="password1Error">Enter password</div>
                    <small id="password1HelpBlock" class="form-text grayColour collapse">
                        Passwords should be 6+ chars with a mixture of special characters, numbers and letters
                    </small>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-11 input-group">
                    <input type="password" class="form-control" id="password2" placeholder="Confirm Password">
                    <div class="input-group-prepend clickable" id="usernameSignInfo" data-toggle="collapse" data-target="#password2HelpBlock" aria-expanded="false" aria-controls="#password2HelpBlock"><span class="input-group-text"><i class="fas fa-question-circle"></i></span></div>
                    <div class="invalid-feedback" id="password2Error">Enter password</div>
                    <small id="password2HelpBlock" class="form-text grayColour collapse">
                        Ensure this password completely matches the first password
                    </small>
                </div>
            </div>
            <div class="form-group row justify-content-center mt-3">
                <div class="col-5">
                    <button type="button" class="btn btn-dark col-12 btn-sm" onclick="signupButton()" id="signupButton">Register</button>
                </div>
            </div>
        </div>
        <div class="col-md-1 d-none d-md-block "></div>
        <div class="col-md-5 col-11 login-window my-3">
            <h1 class="grayColour funkyFont m-3">Register your death.</h1>
            <p class="grayColour small m-3">Today is the first day of the rest of your afterlife, role up and register your soul with the Grim Reaper.<br><br>But whats this? Your soul seems impure, unfavoured by any of the realms gods!<br><br>No, no no... this just wont do... it seems you will have some making up to do soon</p>
        </div>
    </div>
</div>
