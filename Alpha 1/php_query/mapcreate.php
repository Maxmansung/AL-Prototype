<?php
include_once("../login/check_login_status.php");
header("Content-Type: application/json");
if(isset($_POST['map'])){
     $map = preg_replace('#[^[],a-z0-9]#','', $_POST['map']);
     $mapstate = "SELECT * FROM maps WHERE mapname='$map'";
     $mapquery = mysqli_query($db_conx, $mapstate);
     $numrows = mysqli_num_rows($mapquery);
     if ($numrows != 0){
        echo "MAP EXISTS ALREADY";
        } else {
        $createstate = "INSERT INTO maps (mapname) VALUES ('$map')";
        $createquery = mysqli_query($db_conx, $createstate);
        $getidstate = "SELECT mapid FROM maps WHERE mapname='$map'";
        $getidquery = mysqli_query($db_conx, $getidstate);
        $numrows2 = mysqli_num_rows($getidquery);
        if ($numrows2 != 1){
           echo "FAILED FINDING MAP ID";
            } else {
            $row = mysqli_fetch_row($getidquery);
            $mapid = $row[0];
            $mapsizestate = "SELECT * FROM testing WHERE data1='test'";
            $mapsizequery = mysqli_query($db_conx, $mapsizestate);
            while ($row = mysqli_fetch_assoc($mapsizequery)){
                $mapsize = $row['mapsize'];
                $players = $row['maxplayers'];
                $buildingcount = $row['buildingcount'];
                }
            $arraycreate = "[";
            for ($y=0;$y<$buildingcount;$y++){
                $arraycreate .= "0,";
               }
            $arraycreate = chop($arraycreate,",");
            $arraycreate .= "]";
            $zones = $mapsize*$mapsize;
            for ($x=0;$x < $zones;$x++){
                $ztype = rand(0, 3);
                $createzones = "INSERT INTO mapzones (mapid, zonenum, environ, buildings) VALUES ($mapid,$x,$ztype,'$arraycreate')";
                $createzquery = mysqli_query($db_conx, $createzones);
                }
            for ($i=0;$i<$players;$i++){
                $uservisibility = "[";
                for ($y=0;$y<$zones;$y++){
                    $uservisibility .= "0,";
                }
                $uservis = chop($uservisibility, ",");
                $uservis .= "]";
                $ingroup = "[";
                for ($y=0;$y<$players;$y++){
                    $ingroup .= "0,";
                }
                $ingroup = chop($ingroup, ",");
                $ingroup .= "]";
                $invited = "[";
                for ($y=0;$y<$players;$y++){
                    $invited .= "0,";
                }
                $invited = chop($invited, ",");
                $invited .= "]";
                $kick = "[";
                for ($y=0;$y<$players;$y++){
                    $kick .= "0,";
                }
                $kick = chop($kick, ",");
                $kick .= "]";
                $known = "[";
                for ($y=0;$y<$players;$y++){
                    $known .= "0,";
                }
                $known = chop($known, ",");
                $known .= "]";
                $creategroupstate = "INSERT INTO ingamegroups (mapid, playergroup, mapping, ingroup, invited, kick, known) VALUES ($mapid, $i, '$uservis', '$ingroup', '$invited', '$kick', '$known')";
                $creategroupquery = mysqli_query($db_conx, $creategroupstate);
            }
            echo "SUCCESS";
          }
        }
     }
?>