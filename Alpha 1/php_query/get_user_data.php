<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])){
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $jsonData = "{";
    $teststate = "SELECT * FROM ingameavatars WHERE mapid='$mapid'";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$username = $row["username"];
    	$loc = $row["zonelocation"];
    	//This sequence creates the player items array
    	$fitems = $row["fitems"];
    	$bagsize = $row["bagsize"];
    	$stamina = $row["stamina"];
    	$alive = $row['alive'];
    	$playergroup = $row['playergroup'];
    	$playerid = $row['playerid'];
    	$agreeinvite = $row['agreeinvite'];
    	$ready = $row["ready"];
		$jsonData .= '"'.$playerid.'":{ "username":"'.$username.'","location":'.$loc.',"fitems":'.$fitems.',"bagsize":'.$bagsize.',"stamina":'.$stamina.',"alive":'.$alive.',"playergroup":'.$playergroup.',"playerid":'.$playerid.', "agreeinvite":'.$agreeinvite.', "ready":'.$ready.'},';
    }
    $jsonData = chop($jsonData, ",");
	$jsonData .= '}';
    echo $jsonData;
}
?>