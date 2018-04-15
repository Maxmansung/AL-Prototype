<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-sm-11 standardWrapper mt-5">
        <div class="row justify-content-end font-weight-bold font-size-2x"><div class="mx-3 mt-2 clickableLink" onclick = "selectPage(this.id)" id="none"><i class="fas fa-reply mr-2"></i>Back</div>
        </div>
        <div class="row">
            <div class="col-12 font-weight-bold font-size-4 px-3">Custom Map</div>
        </div>
        <div class="row justify-content-center py-3">
            <div class="col-11 adminCreateInfo font-size-2 p-3">
                Here you can create custom games. You can only create 1 custom game at a time and this game will need to end or be deleted by an administrator before another can be created.<br><br>
                Custom games are open to all players so you will need to co-ordinate the rest of your group joining unless you want unknown players joining with you.
                <br><br>
                Be aware that speed games require every player on the map to state themselves are ready. Due to this it's a good idea to play games with people you are in communication with so that they can be prompted to mark themselves as "Ready" for the day to end.
            </div>
        </div>
        <?php
        $access = true;
        if ($profile->getAccessEditMap()===0){
            if ($profile->getCreatedMap() != null) {
                $access = false;
                $map = new mapController($profile->getCreatedMap());
                if ($map->getMapID() == null ){
                    $profile->setCreatedMap(null);
                    $profile->uploadProfile();
                    $access = true;
                }
            }
        }
        if ($access === false){
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminNewMapError.php");
        } else {
            include_once($_SERVER['DOCUMENT_ROOT'] . "/gamePages/admin/adminNewMapCreate.php");
        }
        ?>
    </div>
</div>