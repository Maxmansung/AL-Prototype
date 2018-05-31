<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
$avatar = new avatarController($profile->getAvatar());
$map = new mapController($avatar->getMapID());
?>
<script src="/js/ingamePage.js"></script>
<div class="container-fluid pb-3 pageSize">
    <div class="row justify-content-center pt-5">
        <div class="col-sm-11 col-12">
            <div class="row justify-content-between">
                <div class="col-12 d-block d-md-none standardWrapper mb-1 mb-md-0">
                    <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameHUD.php"); ?>
                </div>
                <div class="col-md-5 col-lg-4 col-12 order-1 order-md-0 standardWrapper">
                    <div class="row">
                        <div class="col-12 d-none d-md-block">
                            <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameHUD.php"); ?>
                        </div>
                        <div class="col-12">
                            <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameItems.php"); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-12 mb-1 mb-md-0 order-0 d-none d-sm-block">
                    <div class="showZoneView">
                    <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameZoneView.php"); ?>
                    </div>
                    <div class="showAvatarView d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameAvatarView.php"); ?>
                    </div>
                    <div class="showAvatarOther d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameAvatarOther.php"); ?>
                    </div>
                    <div class="showShrineView d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameShrineView.php"); ?>
                    </div>
                    <div class="showMapView d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameMapView.php"); ?>
                    </div>
                </div>
                <div class="col-md-7 col-12 mb-1 mb-md-0 order-0 d-block d-sm-none">
                    <div class="showZoneView">
                    <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameZoneViewMobile.php"); ?>
                    </div>
                    <div class="showAvatarView d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameAvatarView.php"); ?>
                    </div>
                    <div class="showAvatarOther d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameAvatarOther.php"); ?>
                    </div>
                    <div class="showShrineView d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameShrineView.php"); ?>
                    </div>
                    <div class="showMapView d-none">
                        <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameMapView.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center pt-md-5 pt-1">
        <div class="col-12 col-sm-11">
            <div class="row justify-content-around">
                <div class="col-3 roundedButton grayBorder infoButtonLog clickableTransparent" onclick="changeInfoView(0)">
                    <div class="font-size-4 font-weight-bold d-none d-sm-flex justify-content-center align-items-center" align="center">Log</div>
                    <div class="d-flex d-sm-none flex-column justify-content-center align-items-center p-1" align="center">
                        <i class="fas fa-pencil-alt  font-size-3 "></i>
                        <div class="font-size-2">Log</div>
                    </div>
                </div>
                <div class="col-3 roundedButton grayBorder infoButtonBuild clickableTransparent" onclick="changeInfoView(1)">
                    <div class="font-size-4 font-weight-bold d-none d-sm-flex justify-content-center align-items-center" align="center">Build</div>
                    <div class="d-flex d-sm-none flex-column justify-content-center align-items-center p-1" align="center">
                        <i class="fas fa-home font-size-3 "></i>
                        <div class="font-size-2">Build</div>
                    </div>
                </div>
                <div class="col-3 roundedButton grayBorder infoButtonParty clickableTransparent" onclick="changeInfoView(2)">
                    <div class="font-size-4 font-weight-bold d-none d-sm-flex justify-content-center align-items-center" align="center">Party</div>
                    <div class="d-flex d-sm-none flex-column justify-content-center align-items-center p-1" align="center">
                        <i class="fas fa-users font-size-3 "></i>
                        <div class="font-size-2">Party</div>
                    </div>
                </div>
                <div class="col-3 roundedButton grayBorder infoButtonGods clickableTransparent" onclick="changeInfoView(3)">
                    <div class="font-size-4 font-weight-bold d-none d-sm-flex justify-content-center align-items-center" align="center">Gods</div>
                    <div class="d-flex d-sm-none flex-column justify-content-center align-items-center p-1" align="center">
                        <i class="fas fa-hands font-size-3 "></i>
                        <div class="font-size-2">Gods</div>
                    </div>
                </div>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameBuildings.php"); ?>
            <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameParty.php"); ?>
            <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameShrines.php"); ?>
            <?php include($_SERVER['DOCUMENT_ROOT']."/gamePages/ingame/gameLogpage.php"); ?>
        </div>
    </div>
</div>
<script>getGamePage()</script>