<?php
?>
<nav class="navbar d-md-flex d-none justify-content-between py-0 px-2 align-items-center darkGrayBackground">
    <div class="navbar-brand"><img src="/images/baseImages/titleBanner.png" class="bannerImage"> </div>
    <div class="d-flex flex-column align-items-end">
        <div class="d-flex justify-content-center align-items-center mr-3 clickable" data-toggle="collapse" data-target="#alertBarWrapper" aria-expanded="false" aria-controls="#alertBarWrapper">
            <span class="badge badge-pill badge-dark notificationsCounter">0</span><span class="sr-only"><?php echo $text->loginNavNotifications() ?></span><span class="orangeColour font-size-3"><?php echo $profile->getProfileName() ?> </span>
        </div>
        <div class="funkyFont mx-2" >
            <span class="redColour clickable" onclick="logoutButton()"><?php echo $text->loginNavLogout() ?>  <i class="fas fa-sign-out-alt"></i></span>
        </div>
    </div>
</nav>
<nav class="navbar d-md-none d-flex justify-content-center p-0 darkGrayBackground">
    <div class="navbar-brand"><img src="/images/baseImages/titleBanner.png" class="bannerImage"> </div>
</nav>
<nav class="navbar navbar-expand-md navbar-light justify-content-between whiteBackground">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex flex-column d-md-none align-items-end">
        <div class="d-flex justify-content-center align-items-center mr-3 clickable" data-toggle="collapse" data-target="#alertBarWrapper" aria-expanded="false" aria-controls="#alertBarWrapper">
            <span class="badge badge-pill badge-dark notificationsCounter">0</span><span class="sr-only"><?php echo $text->loginNavNotifications() ?></span><span class="orangeColour font-size-2x font-weight-bold"><?php echo $profile->getProfileName() ?> </span>
        </div>
        <div class="funkyFont mx-2" >
            <span class="redColour clickable font-size-3" onclick="logoutButton()"><?php echo $text->loginNavLogout() ?>  <i class="fas fa-sign-out-alt"></i></span>
        </div>
    </div>
    <div class="navbar-collapse collapse d-md-flex justify-content-md-end" id="navbarSupportedContent">
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3" onclick="goToPage('none')"><?php echo $text->loginNavPlay() ?></div>
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3" onclick="goToPage('forum')"><?php echo $text->loginNavCommunity() ?></div>
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3" onclick="goToPage('spirit')"><?php echo $text->loginNavSpirit() ?></div>
        <?php if ($profile->getAccessAdminPage()===1){
            echo '<div class="customNavbarButton font-size-2x px-2 pb-1 mx-3" onclick="goToPage(\'admin\')">'.$text->loginNavAdmin().'</div>';
        }
        ?>
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3"><?php echo $text->loginNavWiki() ?></div>
        <div class="customNavbarButton font-size-2x px-2 pb-1 mx-3" data-toggle="collapse" data-target="#flagsCollapse" aria-expanded="false" aria-controls="flagsCollapse">
            <?php echo $text->loginNavLanguage() ?> <img class="flagImage" src="/avatarimages/flags/<?php echo $text->getFlag();?>">
        </div>
    </div>
</nav>
<div class="whiteBackground collapse m-0 row px-2 py-0 col-12" id="flagsCollapse">
    <div class="d-flex flex-row">
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/languageFlags.php");?>
    </div>
</div>
<div class="row fixed-top collapse col-12 col-md-6 col-lg-4 pr-0 mr-0" id="alertBarWrapper">
        <div class="px-2" id="alertBar">
            <div class="row col-12 mt-1 mb-2 align-items-center d-flex flex-row">
                <div class="col-1"></div>
                <div class="col-9" align="center">
                    <h2 class="funkyFont mt-2"><?php echo $text->loginNavMessages() ?></h2>
                </div>
                <button type="button" class="close col-1 grayColour" aria-label="Close" data-toggle="collapse" data-target="#alertBarWrapper">
                    <span aria-hidden="true" class="grayColour">&times;</span>
                </button>
            </div>
        </div>
</div>
<script src="/js/navBar.js"></script>
<script>createNotifications()</script>