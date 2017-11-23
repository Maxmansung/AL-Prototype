<?php
include_once("../login/check_login_status.php");
// Initialize any variables that the page might echo
$u = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["username"]);
$userna = "";
$userlevel = "";
$joindate = "";
$lastsession = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["u"])){
	$userna = preg_replace('#[^A-Za-z0-9]#i', '', $_GET['u']);
} else {
    header("location: ../login/login.php");
    exit();
}
// Select the member from the users table
$sql = "SELECT * FROM users WHERE username='$userna' AND activated='1' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
	echo "That user does not exist or is not yet activated, press back";
    exit();
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($userna == $u && $user_ok == true){
	$isOwner = "yes";
}
// Select the member from the achievements table
$sql2 = "SELECT * FROM userachievements WHERE username='$userna' LIMIT 1";
$achieve_query = mysqli_query($db_conx, $sql2);
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
    $user = $row["username"];
	$profile_id = $row["id"];
	$signup = $row["signup"];
	$lastlogin = $row["lastlogin"];
	$joindate = strftime("%b %d, %Y", strtotime($signup));
	$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
	$currentgame = $row["currentgame"];
}
while ($row = mysqli_fetch_array($achieve_query, MYSQLI_ASSOC)) {
    $alphas = $row["alphas"];
    $betas = $row["betas"];
    $bugs = $row["Bug Reports"];
}
if ($currentgame != 0){
     $mpname = "Currently in a game";
    $mpquery = "SELECT mapname FROM maps WHERE mapid='$currentgame' LIMIT 1";
    $mprows = mysqli_query($db_conx, $mpquery);
     $row = mysqli_fetch_row($mprows);
     $mpname = $row[0];
} else {
    $mpname = "No current game";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $user; ?></title>
<link rel="stylesheet" href="../login/signup.css">
<script src="../js/ajax.js"></script>
</head>
<body>
<?php include_once("../templates/template_pageTop.php"); ?>
<div id="pageMiddle">
  <h3><?php echo $user; ?></h3>
  <p><b><?php
    if ($isOwner == "yes"){
    echo "This is your profile page";
    }
   ?></b></p>
  <p>Join Date: <?php echo $joindate; ?></p>
  <p>Last Session: <?php echo $lastsession; ?></p>
  <p>Currently in game: <?php echo $mpname; ?></p>
  <p>Alpha tests played: <?php echo $alphas; ?></p>
  <p>Beta tests played: <?php echo $betas; ?></p>
  <p>Bugs reported: <?php echo $bugs; ?></p>
</div>
<?php include_once("../templates/template_pageBottom.php"); ?>
</body>
</html>