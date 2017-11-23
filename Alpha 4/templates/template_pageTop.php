<?php
if ($profile->getProfileID() != ""){
    $write2 = '<a href="https://www.arctic-lands.com/user.php?u='.$profile->getProfileID().'">'.$profile->getProfileID().'</a><br><br><a href="https://www.arctic-lands.com/joingame.php">Play Game</a><br><br><a href="https://www.arctic-lands.com/forum.php">Forum</a>';
    $write1 = '<a class="toolLink" onclick="logoutButton()" ">Logout</a>';
    if ($profile->getAccountType() == "admin"){
        $access2 = '<a href="https://www.arctic-lands.com/admin/admin.php">Admin</a>';
     } else {
        $access2 = "";
    }
} else{
    $write1 ="";
    $write2 = '<a class="toolLink" onclick="loginScreen()">Login</a>';
    $access2 = "";
}
?>
<script src="/js/errorChecker.js"></script>
<script src="/js/login.js"></script>
<script src="/js/ajaxSystem_JS.js"></script>
<script src="/js/jquery-3.1.1.1.js"></script>
<link rel="stylesheet" href="https://www.arctic-lands.com/templates/template.css">
<div id="headerwrapper">
    <div id="bannerwrap">
    <div id="headerimagewrap">
        <div id="loginbox">
            <?php echo $write2;?>
            <br><br>
            <?php echo $write1;?>
            <br><br>
            <?php echo $access2;?>
        </div>
        <a href="https://www.arctic-lands.com/joingame.php">
            <img src="/images/banner5.png" id="headerimage">
        </a>
        </div>
    </div>
</div>
<div id="loginWrapperHidden">
    <div id="loginWrapper" onclick="loginScreenClose()">
        <div id="loginScreen">
            <div class="loginWindow">
                <div class="wordsVsButton">
                    <div class="loginTitle">
                        Sign In
                    </div>
                    <div class="signinInputBox">
                        Username:
                        <input type="text" id="signinUsername" name="username" onfocus="emptyElement('usernameSigninError')">
                    </div>
                    <div id="usernameSigninError" class="errorBox">
                    </div>
                    <div class="signinInputBox">
                        Password:
                        <input type="password" id="signinPassword" name="password" onfocus="emptyElement('passwordSigninError')">
                    </div>
                    <div id="passwordSigninError" class="errorBox">
                    </div>
                    <div class="signinInputBox">
                        Remember me:
                        <input type="checkbox" id="signinCookie" name="cookies">
                    </div>
                    <div id="recoverPassword">
                    <a  href="/login/forgotten.php">Forgotten your password?</a>
                    </div>
                </div>
                <button class="loginBoxSubmit" id="signinSubmit" onclick="loginButton()">Login</button>
            </div>
            <div id="dividingLine">

            </div>
            <div class="loginWindow">
                <div class="wordsVsButton">
                    <div class="loginTitle">
                        Create new Account
                    </div>
                    <div class="signinInputBox">
                        Username:
                        <input type="text" id="signupUsername" name="username" onfocus="emptyElement('usernameSignupError')">
                    </div>
                    <div id="usernameSignupError" class="errorBox">
                    </div>
                    <div class="signinInputBox">
                        Email:
                        <input type="email" id="signupEmail" name="email" onfocus="emptyElement('emailSignupError')">
                    </div>
                    <div id="emailSignupError" class="errorBox">
                    </div>
                    <div class="signinInputBox">
                        Password:
                        <input type="password" id="signupPassword" name="password" onfocus="emptyElement('passwordSignupError')">
                    </div>
                    <div id="passwordSignupError" class="errorBox">
                    </div>
                    <div class="signinInputBox">
                        Password confirm:
                        <input type="password" id="signupPasswordConfrm" name="password" onfocus="emptyElement('passwordSignupError2')">
                    </div>
                    <div class="signinInputBox">
                        Account creation password:
                        <input type="password" id="adminSecurePassword" name="adminPassword" onfocus="emptyElement('adminPasswordError')">
                    </div>
                    <div id="adminPasswordError" class="errorBox">
                    </div>
                </div>
                <button id="signupSubmit" class="loginBoxSubmit" onclick="signupButton()">Sign-up</button>
            </div>
        </div>
    </div>
    <script>
        loginListener();
    </script>
</div>