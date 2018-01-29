<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
if ($profile->getNightfall() !== 1){
    header("location:/ingame.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/CSS/main.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <script src="/js/ingame.js"></script>
    <script src="/js/nightfall_JS.js"></script>
    <title>Nightfall</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
<article>
    <section class="verticalWrapCentre">
        <div class="horizontalWrap">
            <div id="timerTitle">
                Nightfall over in
            </div>
            <div id="countdownTimer">

            </div>
        </div>
    <img id="nightFall" src="/images/nightScreen.png">
    </section>
    <script>
        ajax_All(47,"none",15);
    </script>
</article>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>