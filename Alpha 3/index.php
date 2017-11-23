<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/intro.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageTop.php"); ?>
<article>
    <section id="intro">
        <h1><strong>Welcome! </strong></h1>
        <br>
        <br>
        This game is currently in alpha phase 3 and is running test games. This is not a complete game and it requires a lot of
        communication and co-ordination to ensure the test games run effectively. Please ensure you have joined the discord channel
        and that you have requested tutorial games before trying to start
        <br>
        <br>
        <?php if ($profile->getProfileID() == ""){
            echo "<strong> Please click <a id=\"interactiveWord\" onclick=\"loginScreen()\">here</a> to begin helping with the alpha test.</strong>";
        } else {
            echo "<strong> Please click <a id=\"interactiveWord\" href='/joingame.php'>here</a> to begin helping with the alpha test.</strong>";
        }
        ?>
    </section>
</article>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/templates/template_pageBottom.php"); ?>
</body>
</html>