<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
if ($profile->getProfileID() !== ""){
    header("location:/index.php");
    exit();
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
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageTop.php"); ?>
<article id="passwordRecoveryWrap">
    <article id="passwordForgottenWindow">
        <div class='loginTitle'>
            Recover Password
        </div>
        <div class="loginDetail">
            A link to recover your password will be sent to your email, this link will expire after an hour.
            <br>
            <br>
            Please check both your inbox and junk box
            <br>
            <br>
        </div>
        <div class='signinInputBox'>
            Username:
            <input type='text' id='playerUsername' name='username' onfocus="emptyElement('recoveryError')">

            </input>
        </div>
        <div class='signinInputBox'>
            Email Address:
            <input type='email' id='playerEmail' name='email' onfocus="emptyElement('recoveryError')">

            </input>
        </div>
        <div id="recoveryError" class="errorBox"></div>
        <button id='forgottenSubmit' class='loginBoxSubmit' onclick='submitForgottenRequest()'>Submit</button>
    </article>
</article>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageBottom.php"); ?>
</body>
</html>