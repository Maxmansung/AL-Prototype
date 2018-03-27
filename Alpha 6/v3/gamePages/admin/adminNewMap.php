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
    </div>
</div>