<?php
?>
<nav class="navbar navbar-expand-md navbar-light d-flex flex-row-reverse" id="navBarBackground">
    <button class="redColour d-flex justify-content-center align-items-center" id="alertButton" data-toggle="collapse" data-target="#alertBarWrapper" aria-expanded="false" aria-controls="#alertBarWrapper">
        <i class="fas fa-bell font-size-3 "></i><span class="badge badge-pill badge-dark" id="notificationsCounter">0</span><span class="sr-only">Notifications</span>
    </button>
    <div class="ml-auto mr-auto clickable" onclick="goToPage('none')">
        <img src="/images/titleBanner.png" class="bannerImage">
    </div>
    <div class="dropright font-size-4">
        <div class="dropdown-toggle profileButton clickable" data-toggle="dropdown" id="dropdownMenuButton"  aria-haspopup="true" aria-expanded="false">
            <span class="funkyFont orangeColour"><?php echo $profile->getProfileID() ?> </span>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button class="btn dropdown-item funkyFont" onclick="goToPage('spirit')">
                <span class="blueColour font-size-3">Spirit</span>
            </button>
            <button class="btn dropdown-item funkyFont" onclick="goToPage('forum')">
                <span class="blueColour font-size-3">Community</span>
            </button>
            <?php if ($profile->getAccountType() <= 3){
                        echo '<button class="btn dropdown-item funkyFont" onclick="goToPage(\'admin\')">
                                <span class="greenColour font-size-3">Admin</span>
                            </button>';
                    }
            ?>
            <button class="btn dropdown-item funkyFont " onclick="logoutButton()">
                <span class="redColour font-size-3">Quit  <i class="fas fa-sign-out-alt"></i></span>
            </button>
        </div>
    </div>
</nav>
<div class="fixed-top collapse" id="alertBarWrapper">
    <div class="row justify-content-end">
        <div class="col-12 col-md-6 col-lg-4" id="alertBar">
            <div class="row col-12 mt-1 mb-2 align-items-center d-flex flex-row">
                <button type="button" class="close col-1 grayColour" aria-label="Close" data-toggle="collapse" data-target="#alertBarWrapper">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="col-11 " align="center">
                    <h2 class="funkyFont mt-2">Messages</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/navBar.js"></script>
<script>createNotifications()</script>