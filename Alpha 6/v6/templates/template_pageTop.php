<?php
if ($profile->getAvatar() != null){
    $avatar = new avatarController($profile->getAvatar());
    $map = new mapController($avatar->getMapID());
    $ingame = true;
} else {
    $ingame = false;
}
?>
<nav class="navbar d-md-flex d-none justify-content-between py-0 px-2 align-items-center darkGrayBackground">
    <div class="navbar-brand clickable" onclick="goToPage('none')"><img src="/images/baseImages/titleBanner.png" class="bannerImage"> </div>
    <?php
    if ($ingame === true){
        echo '<div class="d-none d-md-flex flex-column align-items-center justify-content-center"><div class="whiteColour font-size-2">'.$map->getName().'</div><div class="lightGrayColour font-size-2x">Day '.$map->getCurrentDay().'</div></div>';
    }
    ?>
    <div class="d-flex flex-row">
        <div class="d-flex justify-content-center align-items-center mr-3 clickable" data-toggle="collapse" data-target="#alertBarWrapper" aria-expanded="false" aria-controls="#alertBarWrapper" onclick="markAsViewed()">
            <div class="profileImageCircle"><img src="/avatarimages/<?php echo $profile->getProfilePicture()?>" class="profilePageImage rounded-circle thickBorder grayBorder"> </div>
            <span class="whiteColour font-size-3 font-weight-bold pl-2"><?php echo $profile->getProfileName() ?> </span>
        </div>
        <span class="redColour font-size-3 clickable d-flex justify-content-center align-items-center" onclick="logoutButton()"><i class="fas fa-times"></i></span>
    </div>
</nav>
<nav class="navbar d-md-none d-flex flex-column justify-content-center p-0 darkGrayBackground">
    <div class="navbar-brand" onclick="goToPage('none')"><img src="/images/baseImages/titleBanner.png" class="bannerImage"> </div>
    <?php
    if ($ingame === true){
        echo '<div class="d-flex flex-row align-items-center justify-content-center"><div class="grayColour font-size-2 mr-3">'.$map->getName().'</div><div class="whiteColour font-size-2 ">Day '.$map->getCurrentDay().'</div></div>';
    }
    ?>
</nav>
<nav class="navbar navbar-expand-md navbar-light justify-content-between py-0 whiteBackground">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="d-flex flex-row d-md-none align-items-end">
        <div class="d-flex justify-content-center align-items-center mr-3 clickable" data-toggle="collapse" data-target="#alertBarWrapper" aria-expanded="false" aria-controls="#alertBarWrapper" onclick="markAsViewed()">
            <span class="blackColour font-size-3 font-weight-bold pl-2"><?php echo $profile->getProfileName() ?> </span>
        </div>
        <span class="blackColour clickable font-size-3" onclick="logoutButton()"><i class="fas fa-sign-out-alt"></i></span>
    </div>
    <div class="navbar-collapse collapse d-md-flex justify-content-md-center align-items-end" id="navbarSupportedContent">
        <div class="navLinkPlay customNavbarButton font-size-2x px-2 py-2 mx-3" onclick="goToPage('none')"><?php echo $text->loginNavPlay() ?></div>
        <div class="navLinkForum customNavbarButton font-size-2x px-2 py-2 mx-3" onclick="goToPage('forum')"><?php echo $text->loginNavCommunity() ?></div>
        <div class="navLinkSpirit customNavbarButton font-size-2x px-2 py-2 mx-3" onclick="goToPage('spirit')"><?php echo $text->loginNavSpirit() ?></div>
        <div class="navLinkScore customNavbarButton font-size-2x px-2 py-2 mx-3" onclick="goToPage('score')"><?php echo $text->loginNavScore() ?></div>
        <?php if ($profile->getAccessAdminPage()===1){
            echo '<div class="navLinkAdmin customNavbarButton font-size-2x px-2 py-2 mx-3" onclick="goToPage(\'admin\')">'.$text->loginNavAdmin().'</div>';
        }
        ?>
        <div class="navLinkHelp customNavbarButton font-size-2x px-2 py-2 mx-3" onclick="goToPage('help')"><?php echo $text->loginNavWiki() ?></div>
    </div>
</nav>
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
<script>getAlertSetup()</script>