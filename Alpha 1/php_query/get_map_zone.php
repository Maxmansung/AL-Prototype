<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_SESSION['mapid'])){
    $mapid = preg_replace('#[^a-z0-9]#','', $_SESSION['mapid']);
    $data = preg_replace('#[^[],a-z0-9]#','', $_POST['data']);
    $teststate = "SELECT * FROM ingameavatars WHERE mapid='$mapid' AND username='".$_SESSION['username']."'";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$loc = $row["zonelocation"];
    	$playergroup = $row['playergroup'];
    	$fitems = $row["fitems"];
    	$bagsize = $row["bagsize"];
    	$stamina = $row["stamina"];
    	$ready = $row["ready"];
        }

        $jsonData = '{"u": { "location":'.$loc.',"fitems":'.$fitems.', "bagsize":'.$bagsize.', "stamina":'.$stamina.', "ready":'.$ready.', "playergroup":'.$playergroup.'},';
    $teststate = "SELECT * FROM mapzones WHERE mapid='$mapid' AND zonenum='$loc'";
    $testquery = mysqli_query($db_conx, $teststate);
    while ($row = mysqli_fetch_assoc($testquery)){
    	$location = $row["zonenum"];
    	$environ = $row["environ"];
    	$fitems = $row["fitems"];
    	$depleted = $row["depleted"];
    	$searchcount = $row["searchcount"];
    	$buildings = $row["buildings"];
    	$fuel = $row["fuel"];
    	$groupowner = $row["groupowner"];
        $jsonData .= '"m": { "location":'.$location.',"environ":'.$environ.',"fitems":'.$fitems.', "depleted":'.$depleted.', "searchcount":'.$searchcount.', "buildings":'.$buildings.', "fuel":'.$fuel.', "groupowner":'.$groupowner.' }}';
    }
    echo $jsonData;
}
?>