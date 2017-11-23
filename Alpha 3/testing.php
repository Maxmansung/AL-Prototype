<?php
include_once($_SERVER['DOCUMENT_ROOT']."/templates/check_login.php");
include_once($_SERVER['DOCUMENT_ROOT']."/MVC/data/data.php");
$encryption = data::encryption("test","tousent");
echo $encryption;
?>
<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="CSS/testing.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
</head>
<body>
<script src="/js/buildings_JS.js"></script>
<script src="/js/jquery-3.1.1.1.js"></script>
<script src="/js/testing.js"></script>
<script>
    ajax_getBuildings("testView","none");
</script>
<div >

</div>
</body>
<div id="loadingscreen">
    <div id="loadingwriting">
        <img src="images/loading.png">
    </div>
</div>
</html>

