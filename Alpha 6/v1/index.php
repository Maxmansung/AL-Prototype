<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/CSS/horizontalMain.css">
    <link rel="stylesheet" href="/CSS/portraitMain.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <meta name="google-signin-client_id" content="134675946741-hst7s6r63ff8c5tt4pubanm01am8tb0i.apps.googleusercontent.com">
    <title>Arctic Lands</title>
</head>
<body>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="/js/signinPage.js"></script>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
<div id="loginPageImage">

</div>
<div id="loginPageWrap">
    <div id="loginPageTitle">
        <img id="bannerImage" src="/images/bannerTitle2.png">
    </div>
    <div id="gameFlavourText">
        In the frozen wastelands you cant live forever... but you could live the longest
    </div>
    <div id="loginBox">
        <div id="loginSiteWrapper">
            <div id="otherLinksWrap">
                <div class="otherLinkWriting">Create Account</div>
                <div class="dottedLineVertical"></div>
                <div class="otherLinkWriting">Forgotten Password</div>
            </div>
            <input name="username" type="text" class="loginInputBox" placeholder="Username">
            <input name="password" type="password" class="loginInputBox" placeholder="Password">
            <div id="rememberMeBox">
                <div>
                    Remember Me:
                </div>
                <input name="rememberMe" type="checkbox">
            </div>
            <button id="loginButton">
                Sign-in
            </button>
        </div>
        <div id="breakWrap">
        <div class="dottedLine"></div>
            <div id="orWriting">
                OR
            </div>
            <div class="dottedLine"></div>
        </div>
        <div id="loginOtherWrapper">
            <div class="g-signin2" data-onsuccess="onSignIn"></div>

        </div>
    </div>
    <div id="informationBox">
        Details about how the game works here
    </div>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>