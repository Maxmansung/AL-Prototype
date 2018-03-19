<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row adminWindow col-11 p-0 blackColour justify-content-center mx-0">
    <div class="row justify-content-center align-items-center font-size-5 col-11 pt-4"><i class="fas fa-cogs font-size-4"></i></div>
    <div class="row col-11 font-size-3 py-4">
        Admin page overview
    </div>
    <div class="row col-11 py-3">
        Please use this section responsibly to assist in the progress of the game.
        <br>
        <br>
        Here you will be able create new games, post news updates and even effect the current games in progress if
        you have the right responsibilities.
    </div>
</div>
