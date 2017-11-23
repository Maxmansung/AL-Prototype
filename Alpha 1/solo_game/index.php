<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="map.css">
    <script src="../js/jquery-3.1.1.js"></script>
    <script src="../solo_game/map.js"></script>
    <script src="../solo_game/user_creation.js"></script>
    <script src="../solo_game/user_movement.js"></script>
    <script src="../solo_game/onload.js"></script>
    <script src="../solo_game/zone_info.js"></script>
    <script src="../solo_game/items.js"></script>
    <script src="../solo_game/image_stats.js"></script>
    <script src="../solo_game/stamina.js"></script>
    <script src="../solo_game/buildings.js"></script>
    <script src="../solo_game/temperature.js"></script>
    <script src="../solo_game/item_actions.js"></script>
    <script src="../solo_game/chatbox.js"></script>
    <title>Arctic Land - Solo Tutorial</title>
</head>
<body onload="onloading()">
<header>
    <?php include_once("../templates/template_pageTop.php");?>
</header>
<nav id="navwindow">
    The navigator window with stuff in it
    <select id="chooseplayer">

    </select>
    <button id="playerselect" onclick="playerselect()">Choose</button>
    <div id="staminawrapper">

    </div>
    <button id="staminarefresh" onclick="staminarefresh()">END DAY</button>
</nav>
<nav id="explaining">
    This game is a solo concept that was created prior to the main multiplayer game. If you would like to play the main game please click "Join Game". Otherwise
    please enjoy this solo concept that was created at the beginning of the project
</nav>
<article>
    <div id="wholepage">
        <aside class="edging">

        </aside>
        <section id="Mainwindow">
    <section id="wrapper">
        <section id="col1">
            <section id="mapwrapper">
                <img src="../images/arrowup.png" class="directionbutton" id="butnorth" onclick="movedirection(0,-1,this,'South', 'North')">
                <section id="wrapperEW">
                    <img src="../images/arrowleft.png" class="directionbutton" id="butwest" onclick="movedirection(-1,0,this,'East', 'West')">
                    <section id="surround">
                        <section id="start">
                        </section>
                    </section>
                    <img src="../images/arrowright.png" class="directionbutton" id="buteast" onclick="movedirection(1,0,this,'West', 'East')">
                </section>
                <img src="../images/arrowdown.png" class="directionbutton" id="butsouth" onclick="movedirection(0,1,this,'North', 'South')">
            </section>
            <section id="infowindow">
                <strong>None selected</strong>
            </section>
            <section id="temperature">
                <section id="tempwriting">

                </section>
                <section id="firepitwrapper">
                    <div id="firepitimage">
                        <button onclick="addwood()">Add wood</button>
                        <img src='../images/fireplace.png'>
                        <button onclick="addsnow()">Add snow</button>
                    </div>
                    <div id="firepitwood">

                    </div>
                </section>
            </section>
        </section>
        <section id="actionwrapper">
            <section id="Information">
                Recent Actions
            </section>
            <button id="searchbutton" onclick="searchbutton()">Search</button>
            <br />
            Backpack items
            <div id="backpackwrapper">
                <img src="../images/Backpack.png" id="backpackpic">
                <div id="backpack"  ondrop="bagdrop(event)" ondragover="allowDrop(event)">
                </div>
            </div>
            Current zone items <i>(Drag items from bag to floor)</i>
            <div id="zonewrapper">
                <img src="../images/Ground2.png">
                <div id="zoneitemholder" ondrop="dropground(event)" ondragover="allowDrop(event)">

                </div>
            </div>
            <i>(Actons to perform with items go here)</i>
            <div id="dropdownwrap">
                <select id="itemactions">
                    <option value="none">Error</option>
                </select>
                <button id="actionbutton" onclick="itemvalue()">Action</button>
            </div>
        </section>
       <section id="infowrapper">
            <aside id="zonebuildings">
            </aside>
        </section>
    </section>
            <div id="chatbox">
            </div>
            <input type="text" id="inputchat">
            <button id="submittext" onclick="submittext()">Post</button>
    </section>
        <aside class="edging">

        </aside>
    </div>
</article>
<footer>
    <?php include_once("../templates/template_pageBottom.php");?>
</footer>
</body>
</html>