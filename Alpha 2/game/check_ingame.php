<?php
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
    if ($ingametrue == 0){
        $changeplayer = "UPDATE users SET currentgame=0 WHERE username='$u'";
        $changeplayerquery = mysqli_query($db_conx, $changeplayer);
        header("location: http://www.arctic-lands.online/game/joingame.php");
    }
} else {
    header("location: http://www.arctic-lands.online/game/joingame.php");
}
?>