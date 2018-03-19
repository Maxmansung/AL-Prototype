<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div>This is the join game page, you are not currently in a game</div>
