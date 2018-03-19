<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5 d-none d-md-block mt-3"><img src="/images/titleBanner.png" class="img-fluid"></div>
    </div>
    <?php
        include_once($_SERVER['DOCUMENT_ROOT']."/gamePages/login/loginScreen.php");
        include_once($_SERVER['DOCUMENT_ROOT']."/gamePages/login/signupScreen.php");
        include_once($_SERVER['DOCUMENT_ROOT']."/gamePages/login/forgottenPage.php");
        include_once($_SERVER['DOCUMENT_ROOT']."/gamePages/login/newsPage.php");
    ?>
</div>
<script src="/js/pageTransitions.js"></script>
<script>loadLoginPage()</script>
