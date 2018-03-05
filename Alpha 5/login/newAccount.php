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
    <link rel="stylesheet" href="/CSS/signup.css">
    <link rel="icon" href="/images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="/images/iconSnowman.png" type="image/x-icon"/>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
        <div id="loginOverviewWrapOrientation">
            <section id="introWritingOrientation">
                <div id="introTextTitle2">
                    Please sign up to the <a class="discordLink" href="https://discord.gg/k69X8yH">discord channel</a> to find the account creation password
                </div>
                <div id="extraHorizontalWriting">
                    Arctic lands is a game about survival in the arctic wilderness, the aim is to survive as many days as possible.
                    <br>
                    <br>
                    The main game consists of real time games that are played with multiple other people, every day at 10pm (GMT) the day will end and anyone unable to get themselves warm enough will find themselves at risk of death.
                    <br>
                    <br>
                    You can choose to work with or against others on the map and throughout the game there will be multiple different ways to improve your chances and make yourself safer, try to find techniques that work for you.
                </div>
            </section>
            <div id="loginWrapperOrientation">
                <div class="loginOrientation">
                    <div class="loginText">Username:</div>
                    <div class="loginExplinationText">Please avoid unusual characters</div>
                    <input type="text" id="signupUsername" name="username" class="loginInputBox" onfocus="emptyElement('usernameSignupError')">
                </div>
                <div id="usernameSignupError" class="errorBox">
                </div>
                <div class="loginOrientation">
                    <div class="loginText">Email:</div>
                    <div class="loginExplinationText">A confirmation email will be sent to this address</div>
                    <input type="email" id="signupEmail" name="email" class="loginInputBox" onfocus="emptyElement('emailSignupError')">
                </div>
                <div id="emailSignupError" class="errorBox">
                </div>
                <div class="loginOrientation">
                    <div class="loginText">Password:</div>
                    <div class="loginExplinationText">Try to use a mixture of characters to secure your account</div>
                    <input type="password" id="signupPassword" name="password" class="loginInputBox" onfocus="emptyElement('passwordSignupError')">
                </div>
                <div id="passwordSignupError" class="errorBox">
                </div>
                <div class="loginOrientation">
                    <div class="loginText">Password confirm:</div>
                    <div class="loginExplinationText">Please make sure this matches your password</div>
                    <input type="password" id="signupPasswordConfrm" name="password" class="loginInputBox" onfocus="emptyElement('passwordSignupError2')">
                </div>
                <div id="passwordSignupError2" class="errorBox"></div>
                <div class="loginOrientation">
                    <div class="loginText">Account creation password:</div>
                    <div class="loginExplinationText">This is used to prevent account flooding, please request this from the discord forum</div>
                    <input type="password" id="adminSecurePassword" name="adminPassword" class="loginInputBox" onfocus="emptyElement('adminPasswordError')">
                </div>
                <div id="adminPasswordError" class="errorBox"></div>
                <br>
                <div><a href="/index.php" class="returnWriting">Already got an account?</a></div>
                <br>
                <button id="signupSubmit" class="loginBoxSubmit" onclick="signupButton()">Sign-up</button>
            </div>
        </div>
<script>
    loginListener();
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>