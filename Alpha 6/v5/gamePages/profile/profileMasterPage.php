<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
if(isset($_GET["p"])){
    $person = $_GET["p"];
} else {
    $person = $profile->getProfileID();
}
echo "<div class='d-none getDataClass'  id='".$person."'></div>"
?>
<script src="/js/profilePage.js"></script>
<div class="container-fluid d-block d-md-none mt-5 mb-2">
    <?php
    include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileStats.php");
    include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileOverview.php");
    include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileAchievements.php");
    include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileSearch2.php");
    include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileFoundResults.php");
    ?>
</div>
<div class="container-fluid d-md-block d-none mt-5 mb-2">
    <div class="row justify-content-center p-0 m-0">
        <div class="col-md-6 col-lg-5 col-xl-4 pl-4 pr-3">
            <?php
            include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileOverview.php");
            ?>
        </div>
        <div class="col-md-6 pr-4 pl-3">
        <?php
        include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileStats.php");
        include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileAchievements.php");
        include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileSearch.php");
        ?>
        </div>
    </div>
    <div class="row justify-content-center pt-3 m-0">
        <div class="col-md-10">
        <?
        include ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileFoundResults.php");
        ?>
        </div>
    </div>
</div>
<script>
    loadProfilePage()
</script>
