<?php
if ($u != ""){
    $write2 = '<a href="../game/user.php?u='.$u.'">'.$u.'</a></br></br><a href="../login/logout.php">Logout</a>';
    if ($log_type == "m"){
        $access2 = '<a href="../login/admin.php">Admin</a>';
     }
} else{
$write2 = '<a href="../login/login.php">Login</a></br></br><a href="../login/signup.php">Join</a>';
$access2 = "";
}

?>
<link rel="stylesheet" href="http://www.arctic-lands.online/templates/template.css">
<div id="headerwrapper">
    <div id="bannerwrap">
    <div id="headerimagewrap">
        <div id="loginbox">
        <?php echo $write2;?>
        </br></br>
        <?php echo $access2;?>
        </div>
        <img src="..\images\banner2.png" id="headerimage">
        </div>
    </div>
    <nav id="commonlinks">
    <a href="http://www.arctic-lands.online/game/joingame.php">Join Game</a>
    -----------
    <a href="http://www.arctic-lands.online/solo_game/index.php">Solo Game</a>
    -----------
    <a href="http://www.arctic-lands.online/templates/tutorial.php">Tutorial</a>
    </nav>
</div>