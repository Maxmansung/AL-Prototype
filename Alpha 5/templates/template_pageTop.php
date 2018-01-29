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
        if ($map->getGameType() === "Tutorial") {
            $buttons = '<div class="navButton" onclick="mapPage()">
                    <a class="navButtonGreen" href="/ingame.php">MAP</a>
                        </div>
                        <div class="navButton" onclick="constructPage()">
                    <a class="navButtonGreen" href="/ingame.php?p=c">CONSTRUCT</a>
                        </div>';
        } else {
            $buttons = '<div class="navButton" onclick="diaryPage()">
                    <a class="navButtonGreen" href="/ingame.php">DIARY</a>
                        </div>
                        <div class="navButton" onclick="mapPage()">
                    <a class="navButtonGreen" href="/ingame.php?p=m">MAP</a>
                        </div>
                        <div class="navButton" onclick="playersPage()">
                    <a class="navButtonGreen" href="/ingame.php?p=p">PLAYERS</a>
                        </div>
                        <div class="navButton" onclick="constructPage()">
                    <a class="navButtonGreen" href="/ingame.php?p=c">CONSTRUCT</a>
                        </div>';
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
    $name = $profile->getProfileID();
    echo '<div id="navBarBackground">
                <div class="verticalWrap">
                    <img src="/images/bannerMini.png" id="navImageBanner">
                    <div class="playerNameHUD">Logged in as: '.$name.'</div>
                </div>
                <div id="navBar">
                <div class="navButton">
                    '.$forum.'
                </div>
                <div class="navButton">
                    <span class="navButtonBlue" id="'.$profile->getProfileID().'" onclick="profilePage(this.id)">PROFILE</span>
                </div>
                '.$buttons.'
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