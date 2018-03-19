<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row adminWindow col-11 p-0 blackColour justify-content-center mx-0">
    <div class="row col-11 py-4 justify-content-between">
        <div>Create News</div>
        <div>Edit News</div>
    </div>
    <div class="row col-11 font-size-3 justify-content-center">
        <div>News Page</div>
    </div>
    <div class="row col-11 py-3">
        This is where news stuff will happen
    </div>
</div>