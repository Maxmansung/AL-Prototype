<?php
include_once("../login/check_login_status.php");
$u = $_SESSION['username'];
$map = $_POST['mapid'];

//This checks to make sure the user isnt already in a game
$user_check = "SELECT * FROM users WHERE username='$u' AND currentgame!='0'";
$user_query = mysqli_query($db_conx, $user_check);
$numrows = mysqli_num_rows($user_query);
if ($numrows > 0){
	echo "ERROR - This player is already in a game";
    exit();
}
//This updates the user information into the game
$usermapchange = "UPDATE users SET currentgame='$map' WHERE username='$u'";
$userquery = mysqli_query($db_conx, $usermapchange);
//This updates the map to include the new user
$playercount = "SELECT players FROM maps WHERE mapid='$map'";
$countquery = mysqli_query($db_conx, $playercount);
while ($row = mysqli_fetch_array($countquery, MYSQLI_ASSOC)) {
    $count = $row['players'];
}
$mapsizestate = "SELECT mapsize, bagsize, maxplayers FROM testing WHERE data1='test'";
$mapsizequery = mysqli_query($db_conx, $mapsizestate);
while ($row = mysqli_fetch_assoc($mapsizequery)){
    $mapsize = $row['mapsize'];
    $bagsize = $row['bagsize'];
    $maxplayers = $row['maxplayers'];
}
$zones = ($mapsize*$mapsize)-1;
if ($count >= ($maxplayers-1)){
    $timer = round(microtime(true) * 1000);
    $full_state = "UPDATE maps SET active='a', timer='$timer' WHERE mapid='$map'";
    $full_query = mysqli_query($db_conx, $full_state);
}
$addplayer = "UPDATE maps SET players=players+1 WHERE mapid='$map'";
$mapquery = mysqli_query($db_conx, $addplayer);
//This adds the player to the useravatar table
$location = rand(0, $zones);
//This will create the array of visibility for the player. 144 is a 12x12 region, this will need to change for different maps
$agreeinvite = "[";
for ($x=0;$x<$maxplayers;$x++){
$agreeinvite .= "0,";
}
$agreeinvite = chop($agreeinvite, ",");
$agreeinvite .= "]";
//This will create the bag for the player
$bagitems = '["Torch",';
for ($x=0;$x<($bagsize-1);$x++){
    $bagitems .= '"ZZNone",';
}

$bagits = chop($bagitems, ",");
$bagits .= "]";
$addplayer2 = "INSERT INTO ingameavatars (username, mapid, zonelocation, playergroup, playerid, fitems, bagsize, agreeinvite) VALUES ('$u', '$map', '$location', '$count', '$count', '$bagits', '$bagsize', '$agreeinvite')";
$addquery2 = mysqli_query($db_conx, $addplayer2);
header("location: map.php");
?>