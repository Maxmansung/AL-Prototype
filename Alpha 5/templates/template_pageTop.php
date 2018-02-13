<script src="/js/errorChecker.js"></script>
<script src="/js/login.js"></script>
<script src="/js/ajaxSystem_JS.js"></script>
<script src="/js/jquery-3.1.1.1.js"></script>
<script src="/js/toolBar_JS.js"></script>
<link rel="stylesheet" href="/templates/template.css">
<?php
if ($profile->getProfileID() == ""){
     echo '<div id="headerwrapper">
                <div id="bannerwrap">
                    <a href="/joingame.php">
                        <img src="/images/banner5.png" id="headerimage">
                    </a>
                </div>
            </div>';
} else {
    if ($profile->getPostsNew() !== false){
        $forum = "navButtonAlert";
    } else {
        $forum = "navButton";
    }
    if ($profile->getGameStatus() === "in") {
        $avatar = new avatarController($profile->getAvatar());
        $map = new mapController($avatar->getMapID());
        $zone = new zoneController($avatar->getZoneID());
        if (intval($zone->getBiomeType()) === 100){
            $constructButton = '<div class="navButton">
                    <a class="navButtonGreen" id="specialZoneWriting" href="/ingame.php?p=s">SHRINE</a>
                        </div>';
        } else {
            $constructButton = '<div class="navButton">
                    <a class="navButtonGreen" id="specialZoneWriting" href="/ingame.php?p=c">CONSTRUCT</a>
                        </div>';
        }
        if ($map->getGameType() === "Tutorial") {
            $buttons = '<div class="navButton">
                    <a class="navButtonGreen" href="/ingame.php">MAP</a>
                        </div>'.$constructButton;
        } else {
            $buttons = '<div class="navButton">
                    <a class="navButtonGreen" href="/ingame.php">DIARY</a>
                        </div>
                        <div class="navButton">
                    <a class="navButtonGreen" href="/ingame.php?p=m">MAP</a>
                        </div>
                        <div class="navButton">
                    <a class="navButtonGreen" href="/ingame.php?p=p">PLAYERS</a>
                        </div>'.$constructButton;
        }
    } else {
        $buttons = '<div class="navButton">
                    <a class="navButtonGreen" href="/joingame.php">JOIN GAME</a>
                        </div>';
    }
    if (count($profile->getForumPosts()) <= 0){
        $forum = '<a class="navButtonBlue" href="/forum.php">FORUM</a>';
    } else {
        $forum = '<a class="navButtonFlash" href="/forum.php"">FORUM</a>';
    }
    if ($profile->getAccountType() === "admin"){
        $admin = '<div class="navButton">
                    <a class="navButtonRed" href="/admin/admin.php">ADMIN</a>
                </div>';
    } else {
        $admin = "";
    }
    $name = $profile->getProfileID();
    echo '<div id="navBarBackground">
                <div class="verticalWrap">
                    <img src="/images/bannerMini.png" id="navImageBanner" onclick="homePage()">
                    <div class="playerNameHUD">Logged in as: '.$name.'</div>
                </div>
                <div id="navBar">
                <div class="navButton">
                    '.$forum.'
                </div>
                <div class="navButton">
                    <a class="navButtonBlue" href="/user.php?u='.$name.'">PROFILE</a>
                </div>
                '.$buttons.$admin.'
                <div class="navButton"  onclick="logoutButton()">
                    <span class="navButtonRed">LOGOUT</span>
                </div>
            </div>
         </div>
         <div id="paddingTop">
         </div>';
}
?>
<script>
    blink();
</script>