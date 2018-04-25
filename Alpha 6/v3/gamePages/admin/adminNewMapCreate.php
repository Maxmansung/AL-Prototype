<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-11">
        <div class="row px-3 justify-content-around mb-3 align-items-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-12">
                <input class="form-control" type="text" maxlength="20" placeholder="Map Name" id="createMapName" autofocus>
                <div class="invalid-feedback" id="mapNameError">This name has been taken</div>
            </div>
            <div class="col-lg-5 col-md-6 col-12 darkGrayColour font-size-2" align="right">
                Leave this blank and a random name will be created
            </div>
        </div>
        <div class="row px-3 justify-content-around mb-3 align-items-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-12">
                <input class="form-control" type="number" min="1" max="40" placeholder="Player Count" id="createMapPlayers">
                <div class="invalid-feedback" id="playerCountError">This size cannot be used</div>
            </div>
            <div class="col-lg-5 col-md-6 col-12 darkGrayColour font-size-2" align="right">
                1-40 players
            </div>
        </div>
        <div class="row px-3 justify-content-around mb-3 align-items-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-12">
                <input class="form-control" type="number" min="3" max="30" placeholder="Edge Size" id="createMapEdge">
                <div class="invalid-feedback" id="edgeSizeError">This size cannot be used</div>
            </div>
            <div class="col-lg-5 col-md-6 col-12 darkGrayColour font-size-2" align="right">
                3-30 zones wide, be careful with extremes
            </div>
        </div>
        <?php if ($profile->getAccessEditMap()===1) {
            echo '<div class="row px-3 justify-content-around mb-3 align-items-center" >
                    <div class="col-xl-4 col-lg-5 col-md-6 col-12" >
                        <select class="form-control" id = "createMapType" >
                            <option value = "1" > Main</option >
                            <option value = "2" > Custom</option >
                            <option value = "3" > Practice</option >
                            <option value = "4" > Tutorial</option >
                            <option value = "5" > Test</option >
                        </select >
                    </div >
                    <div class="col-lg-5 col-md-6 col-12 darkGrayColour font-size-2" align = "right" >
                        This is the game type, only senior admins can use this function
                    </div >
                </div >';
        }
        ?>
        <div class="row px-3 justify-content-around mb-3 align-items-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-12">
                <div class="radio">
                    <label><input type="radio" name="createMapType" value="check">Speed Game - <span class="darkGrayColour font-size-2">Ready button</span></label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="createMapType" value="full" checked>Real Time - <span class="darkGrayColour font-size-2">24 hour days</span></label>
                </div>
                <div class="invalid-feedback" id="gameTypeError">Please select a game type</div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <button class="btn btn-dark" onclick="createNewMap()">Create</button>
        </div>
    </div>
</div>