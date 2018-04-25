<nav class="navbar d-flex justify-content-between py-0 px-2 align-items-center darkGrayBackground">
    <div class="navbar-brand"><img src="/images/baseImages/titleBanner.png" class="bannerImage"> </div>
    <div class="d-flex flex-row align-items-center">
        <div><button class="btn btn-link d-none d-sm-flex" onclick="clickRegister()"><?php echo $text->loginNavSignup();?></button></div>
        <div><button class="btn btn-primary btn-sm py-0 ml-sm-3 ml-0 d-flex flex-row align-items-center" onclick="clickSignin()"><i class="fas fa-lock pr-2 font-size-3"></i><span class="font-size-2"><?php echo $text->loginNavLogin();?></span></button></div>
        <div class="clickable pb-1 mx-2" data-toggle="collapse" data-target="#flagsCollapse" aria-expanded="false" aria-controls="flagsCollapse"><img class="flagImage" src="/avatarimages/flags/<?php echo $text->getFlag();?>">
        </div>
    </div>
</nav>
<div class="whiteBackground collapse m-0 row px-2 py-1" id="flagsCollapse">
    <div class="d-flex flex-row flex-wrap">
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/languageFlags.php");?>
    </div>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/login/loginScreen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/login/signupScreen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/login/forgottenPage.php");
?>
<script src="/js/pageTransitions.js"></script>
<script>loadLoginPage()</script>
