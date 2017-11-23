<?php
include_once("../login/check_login_status.php");
$map = $_SESSION['mapid'];
if(isset($_POST['data'])){
     $data = preg_replace('#[^a-z0-9]#','', $_POST['data']);
     $testday = preg_replace('#[^a-z0-9]#','', $_POST['day']);
 }

//This checks to make sure all the users are ready
$ready_check = "SELECT ready FROM ingameavatars WHERE mapid='$map'";
$ready_query = mysqli_query($db_conx, $ready_check);
while ($row = mysqli_fetch_assoc($ready_query)){
    if ($row["ready"] == 0){
        if ($row["alive"] == 1){
            if ($data == "ready"){
                echo "Error v1";
                return;
            }
        }
    }
}
//The number of players in the game
$count_state = "SELECT * FROM maps WHERE mapid='$map' LIMIT 1";
$count_query = mysqli_query($db_conx, $count_state);
while ($row = mysqli_fetch_assoc($count_query)){
    $count = $row["players"];
    $temp = $row["temperature"];
    $daycount = $row["day"];
}
if ($daycount != $testday){
    echo $daycount.", ".$testday;
    return;
}

//The players information
$player_state = "SELECT * FROM ingameavatars WHERE mapid='$map'";
$player_query = mysqli_query($db_conx, $player_state);
while ($row = mysqli_fetch_assoc($player_query)){
        $alive = $row["alive"];
        $username = $row["username"];
        $usergroup = $row["playergroup"];
        if ($alive == 1){
            $stamina = $row["stamina"];
            $fitems = $row["fitems"];
            $fitems = substr($fitems,1);
            $fitems = substr($fitems, 0, -1);
            $fitems = explode(",",$fitems);
            $counting = array_count_values($fitems);
            $survival = 0;
            $survival -= $counting['"Torch"'];
            $location = $row["zonelocation"];
            $location_state = "SELECT * FROM mapzones WHERE mapid='$map' AND zonenum='$location' LIMIT 1";
            $location_query = mysqli_query($db_conx, $location_state);
            while ($row2 = mysqli_fetch_assoc($location_query)){
                $fireplace = $row2["buildings"];
                $zonegroup = $row2["groupowner"];
                $fireplace = substr($fireplace,1);
                $fireplace = substr($fireplace, 0, -1);
                $fireplace = explode(",",$fireplace);
                $fuel = 0;
                if ($fireplace[3] >= 10){
                    $fuel = $row2["fuel"];
                    if ($fireplace[5] >= 30){
                        if ($playergroup == $groupowner){
                            $survival -= floor(3*(sqrt($fuel)));
                        }
                    } else {
                            $survival -= floor(3*(sqrt($fuel)));
                    }
                }
                if ($survival > $temp){
                    $writing = "Dies";
                    $alive_state = "UPDATE ingameavatars SET alive = 0 WHERE mapid='$map' AND username='$username'";
                    $alive_query = mysqli_query($db_conx,$alive_state);
                    $leave_state = "UPDATE users SET currentgame = 0 WHERE username='$username'";
                    $leave_query = mysqli_query($db_conx,$leave_state);
                    $achieve_state = "UPDATE userachievements SET alphas=alphas+1 WHERE username='$username'";
                    $achieve_query = mysqli_query($db_conx,$achieve_state);
                } else {
                    $writing = "Lives";
                    if ($stamina <= 5){
                        $alive_state = "UPDATE ingameavatars SET stamina = stamina+15, ready = 0 WHERE mapid='$map' AND username='$username'";
                        $alive_query = mysqli_query($db_conx,$alive_state);
                    } else {
                        $alive_state = "UPDATE ingameavatars SET stamina = 20, ready = 0 WHERE mapid='$map' AND username='$username'";
                        $alive_query = mysqli_query($db_conx,$alive_state);
                    }
                }
            }
        }
}

//This takes the fuel away from each of the fires and resets the enviroment
$mapsize_state = "SELECT * FROM mapzones WHERE mapid='$map'";
$mapsize_query = mysqli_query($db_conx, $mapsize_state);
while ($row = mysqli_fetch_assoc($mapsize_query)){
    $depleted = $row["depleted"];
    $enviro = $row["environ"];
    $mapzone = $row["zonenum"];
    $searchcount = $row["searchcount"];
    $fuelf = $row["fuel"];
    if ($depleted != 0){
        $deplete_state = "UPDATE mapzones SET searchcount = 0, depleted = 0 WHERE mapid='$map' AND zonenum='$mapzone'";
        $deplete_query = mysqli_query($db_conx,$deplete_state);
        if ($enviro != 0){
            $deplete_state = "UPDATE mapzones SET environ = environ-1 WHERE mapid='$map' AND zonenum='$mapzone'";
            $deplete_query = mysqli_query($db_conx,$deplete_state);
        }
    } else {
        if ($searchcount > 2){
            $deplete_state = "UPDATE mapzones SET searchcount = searchcount-3 WHERE mapid='$map' AND zonenum='$mapzone'";
            $deplete_query = mysqli_query($db_conx,$deplete_state);
        } else {
            $deplete_state = "UPDATE mapzones SET searchcount = 0 WHERE mapid='$map' AND zonenum='$mapzone'";
            $deplete_query = mysqli_query($db_conx,$deplete_state);
        }
    }
    if ($fuelf > 2){
        $fuel_state = "UPDATE mapzones SET fuel = fuel-2 WHERE mapid='$map' AND zonenum='$mapzone'";
        $fuel_query = mysqli_query($db_conx,$fuel_state);
    } else {
        $fuel_state = "UPDATE mapzones SET fuel = 0 WHERE mapid='$map' AND zonenum='$mapzone'";
        $fuel_query = mysqli_query($db_conx,$fuel_state);
    }
}

//This updates the new day and temperature
$newtemp = $temp+(rand(-7, -2)*$daycount);
$newtime = round(microtime(true) * 1000);
$day_state = "UPDATE maps SET day= day+1, temperature='$newtemp', timer='$newtime' WHERE mapid='$map' LIMIT 1";
$day_query = mysqli_query($db_conx, $day_state);


//This updates the mapping for each group
$mapsize_state = "SELECT `mapsize` FROM `testing` WHERE `index`=2";
$mapsize_query = mysqli_query($db_conx, $mapsize_state);
while ($row = mysqli_fetch_assoc($mapsize_query)){
    $mapsize = $row["mapsize"];
}
$zone = $mapsize*$mapsize;
$uservisibility = "[";
for ($y=0;$y<$zones;$y++){
    $uservisibility .= "0,";
}
$uservis = chop($uservisibility, ",");
$uservis .= "]";
$mapping_state = "UPDATE ingamegroups SET mapping='$uservis' WHERE mapid='$map'";
$mapping_query = mysqli_query($db_conx, $mapping_state);

//Checks if the whole map is dead
$alivecount = 0;
$ready_check = "SELECT alive FROM ingameavatars WHERE mapid='$map'";
$ready_query = mysqli_query($db_conx, $ready_check);
while ($row = mysqli_fetch_assoc($ready_query)){
    if ($row["alive"] == 1){
     $alivecount +=1;
    }
}
if ($alivecount == 0){
    $full_state = "UPDATE maps SET active='d' WHERE mapid='$map'";
    $full_query = mysqli_query($db_conx, $full_state);
}


echo "Complete";
?>