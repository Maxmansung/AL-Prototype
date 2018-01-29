<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
$pass = $_GET["p"];
$user = $_GET["u"];
$profileNew = new profileController($user);
$timer = time()-$profileNew->getPasswordRecoveryTimer();
$success = false;
if ($profileNew->getPasswordRecovery() == $pass){
    if ($profileNew->getProfileID() !== "") {
        if ($timer < 3600) {
            $success = true;
        }
    } else {
     $user = "ERROR";
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
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageTop.php"); ?>
<article id="passwordRecoveryWrap">
    <article id="passwordRecoveryWindow">
        <?php
        if ($timer > 3600){
            echo "This link has now expired, you only have an hour to recover your password";
        } else {
            if ($user == "ERROR"){
                echo "An error has occured in the link you were sent, please bug report that an incorrect username was sent via the password recovery system";
            } else {
                if ($success === false) {
                    echo "This link has now expired, please use the most up to date link";
                }
            }
        }
        ?>
        <div id="passwordRecovery" style="display:none"><?php if ($success === true){echo htmlspecialchars($pass);};?></div>
        <div id="username" style="display:none"><?php if ($success === true){echo htmlspecialchars($user);};?></div>
        <script>
            testingScript();
        </script>
    </article>
</article>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageBottom.php"); ?>
</body>
</html>