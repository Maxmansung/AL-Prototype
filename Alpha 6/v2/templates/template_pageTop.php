<?php
?>
<nav class="navbar navbar-expand-lg navbar-light" id="navBarBackground">
    <a class="navbar-brand" href="#">
        <img class="img-fluid" src="/images/gameLogo2.png" alt="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Forum <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Wilderness</a>
            </li>
            <li class="nav-item">
                <?php
                echo '<a class="nav-link" href="#" onclick="ajax_All(199,0)">'.$profile->getProfileID().' <img src="/images/blackIcons/logout.png" class="imgCustom"></a>'
                ?>
            </li>
        </ul>
    </div>
</nav>