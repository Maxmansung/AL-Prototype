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
    <link rel="stylesheet" href="CSS/signup.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
<div id="loginOverviewWrapOrientation">
    <section id="introWritingOrientation">
        <div id="introTextTitle">
            WELCOME
        </div>
        <div id="extraHorizontalWriting">
            This game is currently in alpha phase 4 and is running test games. This is not a complete game and it requires a lot of
            communication and co-ordination to ensure the test games run effectively. Please ensure you have joined the discord channel
            and that you have requested tutorial games before trying to start
            <br>
            <br>
            <a id="alphaPageLink" href="/templates/alpha.php">Click Here To Learn More</a>
        </div>
    </section>
    <div id="loginWrapperOrientation">
        <div class="loginOrientation">
            <div class="loginText">Username:</div>
            <input type="text" id="signinUsername" name="username" class="loginInputBox"  autofocus="autofocus" onfocus="emptyElement('usernameSigninError')">
        </div>
        <div id="usernameSigninError" class="errorBox"></div>
        <div class="loginOrientation">
            <div class="loginText">Password:</div>
            <input type="password" id="signinPassword" name="password" class="loginInputBox" onfocus="emptyElement('passwordSigninError')">
        </div>
        <div id="passwordSigninError" class="errorBox"></div>
        <div class="loginOrientation">
            Remember me:
            <input type="checkbox" id="signinCookie" name="cookies">
        </div>
        <div id="recoverPassword">
            <a  href="/login/forgotten.php">Forgotten your password?</a>
        </div>
        <div><a href="/login/newAccount.php" class="returnWriting">Create new account</a></div>
        <br>
        <button id="signinSubmit" class="loginBoxSubmit" onclick="loginButton()">Log In</button>
    </div>
</div>
<script>
    loginListener();
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>