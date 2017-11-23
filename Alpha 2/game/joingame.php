<?php
include_once("../login/check_login_status.php");
if(!isset($_SESSION["username"])){
    header("location: ../login/login.php");
}else {
    $u = $_SESSION["username"];
}
$writing = "You are currently logged in as ".$u;
$ingame = "SELECT * FROM users WHERE username='$u' AND currentgame!='0'";
$game_query = mysqli_query($db_conx, $ingame);
$ingame_check = mysqli_num_rows($game_query);
if ($ingame_check > 0){
    $gamecheck = "SELECT currentgame FROM users WHERE username='$u' LIMIT 1";
    $gamecheckquery = mysqli_query($db_conx, $gamecheck);
    $row = mysqli_fetch_row($gamecheckquery);
    $mapid = $row[0];
    $gameconfirm = "SELECT * FROM ingameavatars WHERE username='$u' AND mapid='$mapid' AND alive='1'";
    $gameconfirmquery = mysqli_query($db_conx, $gameconfirm);
    $ingametrue = mysqli_num_rows($gameconfirmquery);
    if ($ingametrue > 0){
	    header("location: map.php");
    }
    else {
        $changeplayer = "UPDATE users SET currentgame=0 WHERE username='$u'";
        $changeplayerquery = mysqli_query($db_conx, $changeplayer);
    }
}
//This section gets the current games available
$availmpqry = "SELECT * FROM maps WHERE active = 's'";
$map_query = mysqli_query($db_conx, $availmpqry);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Arctic Lands - Join Game</title>
<link rel="stylesheet" href="../login/signup.css">
<script src="../js/ajax.js"></script>
</head>
<body>
    <?php include_once("../templates/template_pageTop.php"); ?>
    <div id="pageMiddle">
        <strong> <?php echo $writing; ?> </strong>
        </br>
        <div id="joinmaps">
            <?php while ($row = mysqli_fetch_array($map_query, MYSQLI_ASSOC)){
                echo "<form action='adduser.php' method='post'><input type='hidden' name='mapid' value='".$row['mapid']."'><strong>".$row['mapname']."</strong> - - - - Number of players: ".$row['players']."<button class='joinmap' type='submit'>Join</button></form><hr>";
            }
            ?>
        </div>
    </div>
<?php include_once("../templates/template_pageBottom.php"); ?>
</body>
</html>