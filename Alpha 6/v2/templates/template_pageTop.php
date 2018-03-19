<?php
?>
<nav class="navbar navbar-expand-md navbar-light py-1" id="navBarBackground">
    <div class="redColour d-flex justify-content-center align-items-center mr-3" id="alertButton" data-toggle="collapse" data-target="#alertBarWrapper" aria-expanded="false" aria-controls="#alertBarWrapper">
        <i class="fas fa-bell font-size-3 "></i><span class="badge badge-pill badge-dark" id="notificationsCounter">0</span><span class="sr-only">Notifications</span>
    </div>
    <div class="ml-auto mr-auto clickable" onclick="goToPage('none')">
        <img src="/images/titleBanner.png" class="bannerImage">
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse d-md-flex justify-content-md-end" id="navbarSupportedContent">
    <div class="dropright">
        <div class=" nav-item mx-1 d-flex flex-row clickable align-items-center">
            <div class="clickableFlash funkyFont mx-2" onclick="goToPage('spirit')">
                <span class="orangeColour font-size-3"><?php echo $profile->getProfileID() ?> </span>
            </div>
            <div class="clickableFlash funkyFont mx-2" onclick="goToPage('forum')">
                <span class="blueColour font-size-3">Community</span>
            </div>
            <?php if ($profile->getAccountType() <= 3){
                echo '<div class="clickableFlash funkyFont mx-2" onclick="goToPage(\'admin\')">
                                <span class="greenColour font-size-3">Admin</span>
                            </div>';
            }
            ?>
            <div class="clickableFlash funkyFont mx-2" onclick="logoutButton()">
                <span class="redColour font-size-3">Quit  <i class="fas fa-sign-out-alt"></i></span>
            </div>
        </div>
    </div>
    </div>
</nav>
<div class="row fixed-top collapse col-12 col-md-6 col-lg-4 pr-0 mr-0" id="alertBarWrapper">
        <div class="px-2" id="alertBar">
            <div class="row col-12 mt-1 mb-2 align-items-center d-flex flex-row">
                <div class="col-1"></div>
                <div class="col-9" align="center">
                    <h2 class="funkyFont mt-2">Messages</h2>
                </div>
                <button type="button" class="close col-1 grayColour" aria-label="Close" data-toggle="collapse" data-target="#alertBarWrapper">
                    <span aria-hidden="true" class="grayColour">&times;</span>
                </button>
            </div>
        </div>
</div>
<script src="/js/navBar.js"></script>
<script>createNotifications()</script>