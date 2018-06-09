<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
if (isset($_GET['n'])){
    $news = $_GET['n'];
    $page = "newsSingle.php";
} else {
    $news = "";
    $page = "newsList.php";
}
echo "<div class='d-none getDataClass'  id='".$news."'></div>"
?>
<script src="/js/newsPage.js"></script>
<div class="container-fluid pb-3 pageSize">
    <div class="row justify-content-center mt-5">
        <div class="standardWrapper col-12 col-sm-11 col-md-10 mt-sm-5">
            <?php
            include_once($_SERVER['DOCUMENT_ROOT']."/gamePages/other/".$page);
            ?>
        </div>
    </div>
</div>