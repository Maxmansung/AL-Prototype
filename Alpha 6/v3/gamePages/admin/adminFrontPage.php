<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-sm-11 standardWrapper mt-5">
        <div class="row p-4 font-size-4">
            <div class="font-size-2x funkyFont align-items-center font-weight-bold font-size-3"><i class="fas fa-cogs mr-3"></i>Advanced options</div>
        </div>
        <div class="row">
            <div class="px-4 col-12 ">
                Please use this section responsibly to assist in the progress of the game.
                <br>
                <br>
                Here you will be able create new games, post news updates and even effect the current games in progress if
                you have the right responsibilities.
            </div>
        </div>
        <div class="row my-3 justify-content-center">
            <div class="col-11 px-4 font-size-3 standardWrapperTitle font-weight-bold">
                Powers
            </div>
            <?php
            if ($profile->getAccountType() <= 5) {
                echo '<div class="adminLink clickable col-11 p-3 my-2" onclick = "selectPage(this.id)" id = "map" >
                <div class="row justify-content-between align-items-center px-3" >
                    <div class="col-9 d-flex flex-row flex-wrap align-items-center" ><div class="font-size-3 pr-3" > Create Map </div ><div class="font-size-2 darkGrayColour" > Create new maps to play alone or with friends </div ></div >
                    <div class="font-size-4" ><i class="fas fa-globe" ></i ></div >
                </div >
            </div >';
            }
            if ($profile->getAccountType() <= 3) {
                echo '<div class="adminLink clickable col-11 p-3 my-2" onclick = "selectPage(this.id)" id = "report" >
                <div class="row justify-content-between align-items-center px-3" >
                    <div class="col-9 d-flex flex-row flex-wrap align-items-center" ><div class="font-size-3 pr-3" > Manage Reports </div ><div class="font-size-2 darkGrayColour" > Moderators can manage reports made by players </div ></div >
                    <div class="font-size-4" ><i class="fas fa-exclamation-circle" ></i ></div >
                </div >
            </div >';
            }
            if ($profile->getAccountType() <= 2){
                echo '<div class="adminLink clickable col-11 p-3 my-2" onclick = "selectPage(this.id)" id = "news" >
                <div class="row justify-content-between align-items-center px-3" >
                    <div class="col-9 d-flex flex-row flex-wrap align-items-center" ><div class="font-size-3 pr-3" > Post News </div ><div class="font-size-2 darkGrayColour" > This is where you can post news stories </div ></div >
                    <div class="font-size-4" ><i class="far fa-newspaper" ></i ></div >
                </div >
            </div >';
                echo '<div class="adminLink clickable col-11 p-3 my-2" onclick="selectPage(this.id)" id="snowman">
                <div class="row justify-content-between align-items-center px-3">
                    <div class="col-9 d-flex flex-row flex-wrap align-items-center"><div class="font-size-3 pr-3">Manage Maps</div><div class="font-size-2 darkGrayColour">Senior moderators can directly impact maps to deal with issues</div></div>
                    <div class="font-size-4"><i class="fas fa-snowflake"></i></div>
                </div>
            </div>';
            }
            ?>
        </div>
    </div>
</div>
