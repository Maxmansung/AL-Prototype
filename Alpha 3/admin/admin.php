<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
if ($profile->getProfileID() == "" || $profile->getAccountType() != "admin"){
    header("location:/index.php");
    exit();
}
$err = 0;
if (isset($_SESSION["Error"])){
    $err = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["Error"]);
    unset($_SESSION["Error"]);
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../CSS/signup.css">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon"/>
<script src="../js/login.js"></script>
<script src="../js/login.js"></script>
<meta charset="UTF-8">
<title>Admin</title>
</head>
<body>
<div>
<?php include_once("../templates/template_pageTop.php");?>
</div>
<div id="adminpage">
    <br>
    <div id="errorReport">
        <?php
        if (isset($err)){
            if ($err == 1){
                echo "THAT MAP NAME ALREADY EXISTS";
            }
        }
        ?>
    </div>
    <div id="successreport">
        <?php
        if (isset($err)){
            if ($err == 2){
                echo "Map successfully created";
            }
        }
        ?>
    </div>
    <br>
    <form id="createmap" action="../MVC/ajax_php/mapcreate_ajax.php" method="post">
        <div class="admininput">
            Map name:
            <input type="text" id="mapname" name="map" onfocus="emptyElement('status')" maxlength="88">
        </div>
        <div class="admininput">
            Max Players
            <input type="number" id="maxplayers" name="player" onfocus="emptyElement('status')" min="1" max="200" value="20">
        </div>
        <div class="admininput">
            Map edge size
            <input type="number" id="mapedge" name="edge" onfocus="emptyElement('status')" min="1" max="40" value="12">
        </div>
        <div class="admininput">
            Max stamina
            <input type="number" id="maxstamina" name="stamina" onfocus="emptyElement('status')" min="1" max="1000" value="20">
        </div>
        <div class="admininput">
            Day length
            <input type="number" id="daylength" name="length" onfocus="emptyElement('status')" min="1" max="100" value="8">
        </div>
        <div class="admininput">
            Base Night Temp
            <input type="number" id="maxtemp" name="Temp" onfocus="emptyElement('status')" min="-100" max="100" value="-1">
        </div>
        <div class="admininput">
            Base Survivable Temp
            <input type="number" id="survivtemp" name="SurviTemp" onfocus="emptyElement('status')" min="-100" max="100" value="-1">
        </div>
        <div class="admininput">
            Base Temp Modifier
            <input type="number" id="tempmod" name="TempMod" onfocus="emptyElement('status')" min="-100" max="100" value="0">
        </div>
        <div class="admininput">
            Inventory Slots:
            <select id="inventory" name="invent">
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
        </div>
        <button id="loginbtn" type="submit">Create</button>
        <p id="status"></p>
    </form>
</div>
<footer>
<?php include_once("../templates/template_pageBottom.php");?>
</footer>
</body>
</html>