<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/checkLogin.php");
$testing = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/CSS/main.css">
    <link rel="stylesheet" href="/CSS/bootstrap.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="google-signin-client_id" content="134675946741-hst7s6r63ff8c5tt4pubanm01am8tb0i.apps.googleusercontent.com">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arctic Lands</title>
</head>
<script src="/js/jquery-3.1.1.1.js"></script>
<script src="/js/ajaxSystem_JS.js"></script>
<script src="/js/errorChecker.js"></script>
<script src="/js/pageTransitions.js"></script>
<script src="https://apis.google.com/js/api:client.js"></script>
<body class="bg-al-black">
<?php
if ($profile->getProfileID() == ""){
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTopSignout.php");
    include_once($_SERVER['DOCUMENT_ROOT']."/gamePages/loginPages.php");
} else{
    include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php");
}
?>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
<script src="/js/tooltips.js"></script>
</body>
</html>