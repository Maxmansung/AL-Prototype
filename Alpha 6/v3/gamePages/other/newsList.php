<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-11 funkyFont font-size-5">News</div>
</div>
<div class="row justify-content-center" id="newsListWrapper">
</div>
<script>getAllNews()</script>