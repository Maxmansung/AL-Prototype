
<nav class="navbar d-md-flex d-none justify-content-between py-0 px-2 align-items-center darkGrayBackground">
    <div class="navbar-brand"><img src="/images/titleBanner.png" class="bannerImage"> </div>
    <div class="d-flex flex-row align-items-center">
        <div><button class="btn btn-link" onclick="clickSignin()"><?php echo $text->loginNavLogin();?></button></div>
        <div><button class="btn btn-primary btn-sm py-0 ml-3 d-flex flex-row align-items-center" onclick="clickRegister()"><i class="fas fa-lock pr-2 font-size-3"></i><span class="font-size-2"><?php echo $text->loginNavSignup();?></span></button></div>
    </div>
</nav>
<nav class="navbar d-md-none d-flex justify-content-center p-0 darkGrayBackground">
    <div class="navbar-brand"><img src="/images/titleBanner.png" class="bannerImage"> </div>
</nav>
<nav class="navbar navbar-expand-md navbar-light justify-content-between whiteBackground">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex d-md-none flex-row align-items-center align-self-end">
        <div><button class="btn btn-link" onclick="clickSignin()"><?php echo $text->loginNavLogin();?></button></div>
        <div><button class="btn btn-primary btn-sm py-0 ml-3 d-flex flex-row align-items-center" onclick="clickRegister()"><i class="fas fa-lock pr-2 font-size-3"></i><span class="font-size-2"><?php echo $text->loginNavSignup();?></span></button></div>
    </div>
    <div class="navbar-collapse collapse d-md-flex justify-content-md-end align-items-center" id="navbarSupportedContent">
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3" onclick="goToPage('none')"><?php echo $text->loginNavPlay();?></div>
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3"><?php echo $text->loginNavWiki();?></div>
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3" data-toggle="collapse" data-target="#flagsCollapse" aria-expanded="false" aria-controls="flagsCollapse">
            <?php echo $text->loginNavLanguage();?> <img class="flagImage" src="/avatarimages/flags/<?php echo $text->getFlag();?>">
        </div>
    </div>
</nav>
<div class="whiteBackground collapse m-0 row px-2 py-1" id="flagsCollapse">
    <div class="d-flex flex-row">
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
