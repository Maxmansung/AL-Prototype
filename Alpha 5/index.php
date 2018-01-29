<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
if ($profile->getProfileID() !== ""){
    if ($profile->getGameStatus() != "ready"){
        header("location:/ingame.php");
        exit();
    } else {
        header("location:/joingame.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
<article>
    <section class="verticalWrapCentre">
    <div id="loginWritingWrap">
        <section id="introWriting">
            <div id="introTextTitle">
                WELCOME
            </div>
            <div>
            This game is currently in alpha phase 4 and is running test games. This is not a complete game and it requires a lot of
            communication and co-ordination to ensure the test games run effectively. Please ensure you have joined the discord channel
            and that you have requested tutorial games before trying to start
                <br>
                <br>
                <a id="alphaPageLink" href="/templates/alpha.php">Click Here To Learn More</a>
            </div>
        </section>
        <div id='loginScreen'>
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
    </section>
</article>
<script>
    loginListener();
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>