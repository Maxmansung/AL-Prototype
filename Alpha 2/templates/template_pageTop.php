<?php
if ($u != ""){
    $write2 = '<a href="http://www.arctic-lands.online/alpha2/game/user.php?u='.$u.'">'.$u.'</a></br></br><a href="http://www.arctic-lands.online/alpha2/login/logout.php">Logout</a>';
    if ($log_type == "m"){
        $access2 = '<a href="http://www.arctic-lands.online/alpha2/login/admin.php">Admin</a>';
     }
} else{
$write2 = '<a href="http://www.arctic-lands.online/alpha2/login/login.php">Login</a></br></br><a href="http://www.arctic-lands.online/alpha2/login/signup.php">Join</a>';
$access2 = "";
}

?>
<link rel="stylesheet" href="http://www.arctic-lands.online/alpha2/templates/template.css">
<div id="headerwrapper">
    <div id="bannerwrap">
    <div id="headerimagewrap">
        <div id="loginbox">
        <?php echo $write2;?>
        </br></br>
        <?php echo $access2;?>
        </div>
        <img src="..\images\Banner.png" id="headerimage">
        </div>
    </div>
    <nav id="commonlinks">
    <a href="http://www.arctic-lands.online/alpha2/game/joingame.php">Join Game</a>
    -----------
    <a href="http://www.arctic-lands.online/alpha2/solo_game/index.php">Solo Game</a>
    -----------
    <a href="http://www.arctic-lands.online/alpha2/templates/tutorial.php">Tutorial</a>
    </nav>
</div>