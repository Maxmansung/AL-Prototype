<?php
include_once("../login/check_login_status.php");
if(!isset($_SESSION["username"])){
    header("location: ../login/login.php");
}else {
    $u = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["username"]);
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../login/signup.css">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon"/>
<script src="..\js\login.js"></script>
<meta charset="UTF-8">
<title>Tutorial</title>
</head>
<body>
<div>
<?php include_once("template_pageTop.php");?>
</div>
<div id="tutorial">
<h1 id="tutorialhead">Tutorial</h1>
<h2>Basic concept: </h2>
<p>You are in some sort of a post-apocalypse world where everything is cold, arctic cold. Each night
temperatures drop lower and lower and you need to build a fire to survive</p>
<h2>Players </h2>
<p>Except you there are 19 other <strike>assholes</strike> survivors which you can ally or sabotage… Your choice.
 But if you want to survive more than 2 days, you better ally people through the “Players” tab.</p>
<h2>Temperature:</h2>
<p>You must watch this one carefully. It won’t be hard though, it is always in the left corner of your screen.
Survivable temperature is the temperature in the zone you are in, Night temperature shows how much your balls will
freeze during the night. If your ST is lower or equal than the NT you will live another day… eventually</p>
<h2>Stamina: </h2>
<p>Used for practically everything. You regain x(weird number) of stamina each day. Use it wisely or you will
freeze to death, unable to go to the closest fire.</p>
<h2>Zones: </h2>
<p>The world is divided in 144 zones(because c’mon it is a 12x12 array what could possibly go wrong?).
You have to move through them in order to collect the 2 main resources in the game: Wood and snow. Moving
and searching cost you 1 stamina each. Eventually zones will become depleted and refuse to give you more stuff(bad zones!),
overnight they will change their biome.</p>
<h2>Biomes: </h2>
<p>Every different biome has different chance of giving you wood or snow. The higher in quality is one biome
the more wood it gives you. The highest quality is forest, then bushes, then snowfield and then dirt field.
If you deplete a zone, it will drop in quality with 1 overnight(ex: If you deplete a forest it will magically
turn into bushes when you sleep).</p>
<h2>Buildings: </h2>
<p>To survive you need to build. By far the most important building is the firepit, you put wood in it and it keeps
you alive… simple! Other buildings are the outpost(which gives you ownership over the zone), the chest and chest
lock(they are useless right now) and the fence and fence lock(which prevent people from entering your zone).</p>
<h2>How to get rid of other players: </h2>
<p>If you want to get rid of an enemy group you can always go and steal their items or be a total Saran
and throw snowballs into their firepit(each snowball adds -1C, if temperature reaches zero, the fire is destroyed).</p>
</div>
<div id="tutorialby">
Written by: thewolf66
</div>
<footer>
<?php include_once("template_pageBottom.php");?>
</footer>
</body>
</html>