<nav class="navbar d-flex justify-content-between py-0 px-2 align-items-center">
    <div class="clickable pb-1 mx-2" data-toggle="collapse" data-target="#flagsCollapse" aria-expanded="false" aria-controls="flagsCollapse"><img class="flagImage" src="/avatarimages/flags/<?php echo $text->getFlag();?>">
    </div>
    <div class="d-flex flex-row align-items-center transparentWrapper">
        <div><button class="btn btn-link py-0 ml-sm-3 ml-0 d-flex flex-row align-items-end justify-content-center font-weight-bold" onclick="clickSignin()"><span class="font-size-2x whiteColour"><?php echo $text->loginNavLogin();?></span></button></div>
        <div class="d-none py-0 d-sm-flex px-2 whiteColour">or</div>
        <div><button class="btn btn-link d-none py-0 d-sm-flex justify-content-center align-items-end" onclick="clickRegister()"><span class="font-size-2x whiteColour"><?php echo $text->loginNavSignup();?></span></button></div>
    </div>
</nav>
<div class="collapse m-0 row px-2 py-" id="flagsCollapse">
    <div class="d-flex justify-content-start">
        <div class="transparentWrapper d-flex flex-column">
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/languageFlags.php");?>
        </div>
    </div>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/login/loginScreen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/login/signupScreen.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/login/forgottenPage.php");
?>
<script src="/js/pageTransitions.js"></script>
<script>loadLoginPage()</script>
