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
<div class="container">
    <div class="row justify-content-between align-items-start">
        <?php
        include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileOverview.php");
        include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileAchievements.php");
        ?>
        <div class="login-window mt-3 col-12 col-md-5">
            <div class="input-group my-3">
                <input type="text" class="form-control" placeholder="Find Spirits" aria-label="Recipient's username" aria-describedby="basic-addon2" id="searchForUsername">
                <div class="input-group-append">
                    <button class="btn btn-dark" type="button" onclick="searchForSpirits()" id="searchProfileButton"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div id="profilesFound" class="container-fluid justify-content-center">

            </div>
        </div>
    </div>
</div>
<script>
    var data = $(".getDataClass").attr('id');
    ajax_All(35,2,data)
</script>
